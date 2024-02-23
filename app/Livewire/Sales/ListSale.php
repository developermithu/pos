<?php

namespace App\Livewire\Sales;

use App\Enums\PaymentPaidBy;
use App\Enums\SalePaymentStatus;
use App\Models\Payment;
use App\Models\Sale;
use App\Traits\SearchAndFilter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListSale extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    public $selected = [];

    public function render()
    {
        $this->authorize('viewAny', Sale::class);

        $search = $this->search ? '%'.trim($this->search).'%' : null;
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
                if ($value === 'onlyTrashed') {
                    $query->onlyTrashed();
                } elseif ($value === 'withTrashed') {
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

        DB::beginTransaction();

        try {
            // Delete associated payments
            $sale->payments()->forceDelete();
            $sale->forceDelete();

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
        $sale = Sale::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $sale);
        $sale->restore();

        $this->success(__('Record has been restored successfully'));

        return back();
    }

    public function destroyPayment(Payment $payment)
    {
        $this->authorize('delete', $payment);

        $paymentable = $payment->paymentable;

        // Subtract the payment amount from the sale
        $paymentable->paid_amount -= $payment->amount;

        // Update payment_status based on paid_amount
        if ($paymentable->paid_amount > 0 && $paymentable->paid_amount < $paymentable->total) {
            $paymentable->payment_status = SalePaymentStatus::PARTIAL->value;
        } elseif ($paymentable->paid_amount == 0) {
            $paymentable->payment_status = SalePaymentStatus::DUE->value;
        } elseif ($paymentable->paid_amount === $paymentable->total) {
            $paymentable->payment_status = SalePaymentStatus::PAID->value;
        }

        if ($payment->paid_by === PaymentPaidBy::DEPOSIT) {
            $paymentable->customer->decrement('expense', $payment->amount);
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
                $paymentable->payment_status = SalePaymentStatus::PARTIAL->value;
            } elseif ($paymentable->paid_amount == 0) {
                $paymentable->payment_status = SalePaymentStatus::DUE->value;
            } elseif ($paymentable->paid_amount === $paymentable->total) {
                $paymentable->payment_status = SalePaymentStatus::PAID->value;
            }

            if ($payment->paid_by === PaymentPaidBy::DEPOSIT) {
                $paymentable->customer->increment('expense', $payment->amount);
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
