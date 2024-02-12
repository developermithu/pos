<?php

namespace App\Livewire\Purchases;

use App\Enums\PurchasePaymentStatus;
use App\Models\Payment;
use App\Models\Purchase;
use App\Traits\SearchAndFilter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListPurchase extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    public $selected = [];

    public function render()
    {
        $this->authorize('viewAny', Purchase::class);

        $search = $this->search ? '%'.trim($this->search).'%' : null;
        $searchableFields = ['invoice_no'];

        $purchases = Purchase::query()
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->with('supplier:id,name')
            ->when($this->filterByTrash, function ($query, $value) {
                if ($value === 'onlyTrashed') {
                    $query->onlyTrashed();
                } elseif ($value === 'withTrashed') {
                    $query->withTrashed();
                }
            })
            ->latest('id')
            ->paginate(20);

        return view('livewire.purchases.list-purchase', compact('purchases'))->title(__('purchase list'));
    }

    public function deleteSelected()
    {
        $this->authorize('bulkDelete', Purchase::class);

        if ($this->selected) {
            Purchase::destroy($this->selected);
            $this->success(__('Selected records has been deleted'));
        } else {
            $this->success(__('You did not select anything'));
        }

        return back();
    }

    public function destroy(Purchase $purchase)
    {
        $this->authorize('delete', $purchase);
        $purchase->delete();

        $this->success(__('Record has been deleted successfully'));

        return back();
    }

    public function forceDelete($id)
    {
        $purchase = Purchase::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $purchase);

        DB::beginTransaction();

        try {
            // Delete associated payments
            $purchase->payments()->forceDelete();
            $purchase->forceDelete();

            DB::commit();
            $this->success(__('Record has been deleted permanently'));
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Error force deleting sale: '.$e->getMessage());
            $this->error(__('Error force deleting sale and payments.'));
        }

        return back();
    }

    public function restore($id)
    {
        $purchase = Purchase::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $purchase);
        $purchase->restore();

        $this->success(__('Record has been restored successfully'));

        return back();
    }

    // delete payment
    public function destroyPayment(Payment $payment)
    {
        $this->authorize('delete', $payment);

        $paymentable = $payment->paymentable;

        // Subtract the payment amount from the purchase
        $paymentable->paid_amount -= $payment->amount;

        // Update payment_status based on paid_amount
        if ($paymentable->paid_amount > 0 && $paymentable->paid_amount < $paymentable->total) {
            $paymentable->payment_status = PurchasePaymentStatus::PARTIAL->value;
        } elseif ($paymentable->paid_amount == 0) {
            $paymentable->payment_status = PurchasePaymentStatus::UNPAID->value;
        } elseif ($paymentable->paid_amount === $paymentable->total) {
            $paymentable->payment_status = PurchasePaymentStatus::PAID->value;
        }

        // Save the changes to
        $paymentable->save();

        $payment->delete();

        $this->success(__('Record has been deleted successfully'));

        return back();
    }

    // restore payment
    public function restorePayment($id)
    {
        $payment = Payment::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $payment);
        $paymentable = $payment->paymentable;

        // Check if restoring the payment won't clear the entire balance
        if ($paymentable->total >= $paymentable->paid_amount + $payment->amount) {
            // Addition of the payment amount to the purchase
            $paymentable->paid_amount += $payment->amount;

            // Update payment_status based on paid_amount
            if ($paymentable->paid_amount > 0 && $paymentable->paid_amount < $paymentable->total) {
                $paymentable->payment_status = PurchasePaymentStatus::PARTIAL->value;
            } elseif ($paymentable->paid_amount == 0) {
                $paymentable->payment_status = PurchasePaymentStatus::UNPAID->value;
            } elseif ($paymentable->paid_amount === $paymentable->total) {
                $paymentable->payment_status = PurchasePaymentStatus::PAID->value;
            }

            // Save the changes
            $paymentable->save();
            $payment->restore();

            $this->success(__('Record has been restored successfully'));
        } else {
            $this->error(__('You cannot restore it. Restoring this payment would clear the entire balance.'));
        }

        return back();
    }

    // force delete payment
    public function forceDeletePayment($id)
    {
        $payment = Payment::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $payment);

        // Payment status is already updated
        // When deleted the payment
        $payment->forceDelete();
        $this->success(__('Record has been deleted permanently'));

        return back();
    }
}
