<?php

namespace App\Livewire\Accounts;

use App\Models\BalanceAdjustment;
use App\Traits\SearchAndFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListBalanceAdjustment extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    public function render()
    {
        $this->authorize('viewAny', BalanceAdjustment::class);

        $searchTerm = $this->search ? '%'.trim($this->search).'%' : null;

        $balanceAdjustments = BalanceAdjustment::query()
            ->with(['payment.account:id,name,account_no'])
            ->when($searchTerm, function (Builder $query) use ($searchTerm) {
                $query->whereHas('payment', function (Builder $subQuery) use ($searchTerm) {
                    $subQuery->where('details', 'like', $searchTerm);
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.accounts.list-balance-adjustment', compact('balanceAdjustments'))
            ->title(__('balance adjustment list'));
    }

    public function forceDelete(BalanceAdjustment $balanceAdjustment)
    {
        $this->authorize('forceDelete', $balanceAdjustment);

        DB::beginTransaction();

        try {
            // Delete associated payment
            $balanceAdjustment->payment()->forceDelete();
            $balanceAdjustment->forceDelete();

            DB::commit();
            $this->success(__('Record has been deleted successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            $this->error(__('Something went wrong!'));
        }

        return back();
    }
}
