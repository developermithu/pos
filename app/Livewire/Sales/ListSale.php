<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use App\Traits\SearchAndFilter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListSale extends Component
{
    use WithPagination, Toast, SearchAndFilter;

    public $selected = [];

    public function render()
    {
        $this->authorize('viewAny', Sale::class);

        $search = $this->search ? '%' . trim($this->search) . '%' : null;
        $searchableFields = ['invoice_no'];

        $sales = Sale::query()
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->with('customer:id,name')
            ->when($this->filterByTrash, function ($query, $value) {
                if ($value === "onlyTrashed") {
                    $query->onlyTrashed();
                } elseif ($value === "withTrashed") {
                    $query->withTrashed();
                }
            })
            ->latest('id')
            ->paginate(20);

        return view('livewire.sales.list-sale', compact('sales'))->title(__('sale list'));
    }

    public function deleteSelected()
    {
        $this->authorize('bulkDelete', Sale::class);

        if ($this->selected) {
            Sale::destroy($this->selected);
            $this->success(__('Selected records has been deleted'));
        } else {
            $this->success(__('You did not select anything'));
        }

        return back();
    }

    public function destroy(Sale $sale)
    {
        $this->authorize('delete', $sale);
        $sale->delete();

        $this->success(__('Record has been deleted successfully'));
        return back();
    }

    public function forceDelete($id)
    {
        $sale = Sale::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $sale);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Delete associated payments
            $sale->payments()->onlyTrashed()->forceDelete();
            $sale->forceDelete();

            DB::commit();
            $this->success(__('Record has been deleted permanently'));
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Error force deleting sale: ' . $e->getMessage());
            $this->error(__('Error force deleting sale and payments.'));
        }

        return back();
    }

    public function restore($id)
    {
        $sale = Sale::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $sale);
        $sale->restore();

        $this->success(__('Record has been restored successfully'));
        return back();
    }
}
