<?php

namespace App\Livewire\Suppliers;

use App\Enums\PaymentPaidBy;
use App\Enums\PaymentType;
use App\Enums\PurchasePaymentStatus;
use App\Models\Deposit;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Traits\SearchAndFilter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListSupplier extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    public $selected = [];

    // For clearing due
    public int $amount;
    public ?string $note = null;

    public bool $showDrawer = false;
    public string $supplier_id;

    // Deposit Operations
    public Supplier $supplier;
    public bool $showModal = false;
    public int $deposit_amount;
    public ?string $details = null;

    public function deleteSelected()
    {
        $this->authorize('bulkDelete', Supplier::class);

        Supplier::destroy($this->selected);

        $this->success(__('Selected records has been deleted'));

        return back();
    }

    public function destroy(string $ulid)
    {
        $supplier = Supplier::whereUlid($ulid)->firstOrFail();

        $this->authorize('delete', $supplier);
        $supplier->delete();
        $this->success(__('Record has been deleted successfully'));
    }

    public function forceDelete(string $ulid)
    {
        $supplier = Supplier::onlyTrashed()->whereUlid($ulid)->firstOrFail();

        $this->authorize('forceDelete', $supplier);
        $supplier->forceDelete();
        $this->success(__('Record has been deleted permanently'));
    }

    public function restore(string $ulid)
    {
        $supplier = Supplier::onlyTrashed()->whereUlid($ulid)->firstOrFail();

        $this->authorize('restore', $supplier);
        $supplier->restore();
        $this->success(__('Record has been restored successfully'));
    }

    public function render()
    {
        $this->authorize('viewAny', Supplier::class);

        $search = $this->search ? '%' . trim($this->search) . '%' : null;
        $searchableFields = ['name', 'company_name', 'address', 'phone_number'];

        $suppliers = Supplier::query()
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
            ->with('purchases:id,total,paid_amount,supplier_id', 'deposits')
            ->paginate(10);

        return view('livewire.suppliers.list-supplier', compact('suppliers'))
            ->title(__('supplier list'));
    }

    public function showDepositModal(Supplier $supplier)
    {
        $this->supplier = $supplier;
        $this->showModal = true;
    }

    public function addDeposit()
    {
        $this->validate([
            'deposit_amount' => ['required', 'integer', 'numeric', 'gt:0'],
            'details' => ['nullable', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {
            $deposit = $this->supplier->deposits()->create([
                'amount' => $this->deposit_amount,
                'details' => $this->details,
            ]);

            Payment::create([
                'account_id' => 1, //cash
                'amount' => $this->deposit_amount,
                'reference' => 'Supplier deposit',
                'details' => $this->details,
                'type' => PaymentType::DEBIT,
                'paid_by' => PaymentPaidBy::CASH,
                'paymentable_id' => $deposit->id,
                'paymentable_type' => Deposit::class,
            ]);

            // increase the supplier's deposit
            $this->supplier->increment('deposit', $this->deposit_amount);
            DB::commit();

            $this->showModal = false;
            $this->reset(['deposit_amount', 'details']);
            $this->success(__('Deposit has been added.'));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            $this->error(__('Something went wrong.'));
        }

        return back();
    }

    public function forceDeleteDeposit(Deposit $deposit)
    {
        $this->authorize('forceDelete', $deposit);
        DB::beginTransaction();

        try {
            $depositable = $deposit->depositable;

            // If the depositable is a supplier, decrease the supplier's deposit
            if ($depositable instanceof Supplier) {
                $depositable->decrement('deposit', $deposit->amount);
            }

            $deposit->forceDelete();
            $deposit->payment?->forceDelete();

            DB::commit();
            $this->success(__('Record has been deleted permanently'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->error(__('Something went wrong.'));
        }
    }

    public function showDueModal(string $supplierId)
    {
        $this->supplier_id = $supplierId;
        $this->showDrawer = true;
    }

    public function clearDue()
    {
        $this->validate([
            'amount' => ['required', 'integer', 'numeric', 'gt:0'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {
            $remainingAmount = $this->amount;

            $purchases = Purchase::select('id', 'total', 'paid_amount', 'payment_status')
                ->where('payment_status', '!=', PurchasePaymentStatus::PAID)
                ->where('supplier_id', $this->supplier_id)
                ->oldest()
                ->get();

            if ($purchases->isEmpty()) {
                $this->error(__('No unpaid purchases found for the supplier.'));
                return; // Exit the method
            }

            foreach ($purchases as $purchase) {
                if ($remainingAmount <= 0) {
                    break;
                }

                $dueAmount = $purchase->total - $purchase->paid_amount;
                $paidAmount = min($remainingAmount, $dueAmount);
                $remainingAmount -= $paidAmount;

                $paymentStatus = $paidAmount >= $dueAmount
                    ? PurchasePaymentStatus::PAID->value
                    : PurchasePaymentStatus::PARTIAL->value;

                $purchase->payments()->create([
                    'account_id' => 1, // cash
                    'amount' => $paidAmount,
                    'reference' => 'Clearing supplier due',
                    'type' => PaymentType::DEBIT,
                    'paid_by' => PaymentPaidBy::CASH,
                    'details' => $this->note,
                ]);

                $purchase->paid_amount += $paidAmount;
                $purchase->payment_status = $paymentStatus;
                $purchase->save();
            }

            DB::commit();

            $this->showDrawer = false;
            $this->reset(['amount', 'note']);
            $this->success(__('Due has been cleared.'));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            $this->error(__('An error occurred while clearing due. Please try again.'));
        }

        return back();
    }
}
