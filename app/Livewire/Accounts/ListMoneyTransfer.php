<?php

namespace App\Livewire\Accounts;

use App\Enums\PaymentType;
use App\Models\Account;
use App\Models\MoneyTransfer;
use App\Models\Payment;
use App\Traits\SearchAndFilter;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListMoneyTransfer extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    #[Validate('required|exists:accounts,id')]
    public int|string $from_account_id = '';

    #[Validate('required|exists:accounts,id|different:from_account_id')]
    public int|string $to_account_id = '';

    #[Validate('required|numeric|integer|min:10')]
    public ?int $amount;

    public $selected = [];

    public function render()
    {
        $this->authorize('viewAny', MoneyTransfer::class);

        $search = $this->search ? '%' . trim($this->search) . '%' : null;
        $searchableFields = ['amount'];

        $moneyTransfers = MoneyTransfer::query()
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->when($this->filterByTrash, function ($query, $value) {
                if ($value === 'onlyTrashed') {
                    $query->onlyTrashed();
                } elseif ($value === 'withTrashed') {
                    $query->withTrashed();
                }
            })
            ->latest()
            ->paginate(10);

        return view('livewire.accounts.list-money-transfer', compact('moneyTransfers'))
            ->title(__('money transfer list'));
    }

    public function create()
    {
        $this->authorize('create', MoneyTransfer::class);

        $this->validate();

        $fromAccount = Account::findOrFail($this->from_account_id);

        if ($fromAccount->totalBalance() < $this->amount) {
            $this->error('You have only ' . number_format($fromAccount->totalBalance()) . ' tk in ' . $fromAccount->name, timeout: 5000);
        } else {
            DB::beginTransaction();

            try {
                $moneyTransfer = MoneyTransfer::create($this->only(['from_account_id', 'to_account_id', 'amount']));

                // From Account Paymen
                Payment::create([
                    'account_id' => $this->from_account_id,
                    'amount' => $this->amount,
                    'reference' => 'Transfer-' . date('Ymd') . '-' . rand(00000, 99999),
                    'type' => PaymentType::DEBIT->value, // debit
                    'paymentable_id' => $moneyTransfer->id,
                    'paymentable_type' => MoneyTransfer::class,
                ]);

                // To Account Payment
                Payment::create([
                    'account_id' => $this->to_account_id,
                    'amount' => $this->amount,
                    'reference' => 'Transfer-' . date('Ymd') . '-' . rand(00000, 99999),
                    'type' => PaymentType::CREDIT->value, // credit
                    'paymentable_id' => $moneyTransfer->id,
                    'paymentable_type' => MoneyTransfer::class,
                ]);

                DB::commit();

                $this->reset();
                $this->success(__('Record has been created successfully'));
                $this->dispatch('close');
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Money transfer: ' . $e->getMessage());
                $this->error(__('Something went wrong!'));
            }
        }
    }

    public function deleteSelected()
    {
        $this->authorize('bulkDelete', MoneyTransfer::class);

        if ($this->selected) {
            MoneyTransfer::destroy($this->selected);
            $this->success(__('Selected records has been deleted'));
        } else {
            $this->success(__('You did not select anything'));
        }

        return back();
    }

    public function destroy(MoneyTransfer $moneyTransfer)
    {
        $this->authorize('delete', $moneyTransfer);
        $moneyTransfer->delete();

        $this->success(__('Record has been deleted successfully'));

        return back();
    }

    public function forceDelete($id)
    {
        $moneyTransfer = MoneyTransfer::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $moneyTransfer);

        DB::beginTransaction();

        try {
            // Delete associated payments
            $moneyTransfer->payments()->forceDelete();
            $moneyTransfer->forceDelete();

            DB::commit();
            $this->success(__('Record has been deleted permanently'));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            $this->error(__('Something went wrong!'));
        }

        return back();
    }

    public function restore($id)
    {
        $moneyTransfer = MoneyTransfer::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $moneyTransfer);
        $moneyTransfer->restore();

        $this->success(__('Record has been restored successfully'));

        return back();
    }
}
