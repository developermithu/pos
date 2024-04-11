<?php

namespace App\Livewire\Purchases;

use App\Models\Payment;
use App\Models\Purchase;
use App\Services\PurchaseService;
use App\Traits\SearchAndFilter;
use Illuminate\Database\Eloquent\Builder;
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

        $search = $this->search ? '%' . trim($this->search) . '%' : null;
        $searchableFields = ['invoice_no'];

        $purchases = Purchase::query()
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
            ->with('supplier:id,name', 'payments', 'payments.account:id,name')
            ->withSum(['payments' => function (Builder $query) {
                $query->whereNull('deleted_at');
            }], 'amount')
            ->latest('id')
            ->paginate(20);

        return view('livewire.purchases.list-purchase', compact('purchases'))->title(__('purchase list'));
    }

    public function deleteSelected(PurchaseService $purchaseService)
    {
        $this->authorize('bulkDelete', Purchase::class);

        if ($this->selected) {
            if ($purchaseService->bulkDeletePurchases($this->selected)) {
                $this->success(__('Selected records have been deleted'));
            } else {
                $this->error(__('Something went wrong'));
            }
        } else {
            $this->success(__('You did not select anything'));
        }
    }

    public function destroy(Purchase $purchase, PurchaseService $purchaseService)
    {
        $this->authorize('delete', $purchase);

        if ($purchaseService->deletePurchase($purchase)) {
            $this->success(__('Record has been deleted successfully'));
        } else {
            $this->error('Something went wrong.');
        }
    }

    public function forceDelete($id, PurchaseService $purchaseService)
    {
        $purchase = Purchase::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $purchase);

        if ($purchaseService->forceDeletePurchase($purchase)) {
            $this->success(__('Record has been deleted permanently'));
        } else {
            $this->error('Something went wrong.');
        }
    }

    public function restore($id, PurchaseService $purchaseService)
    {
        $purchase = Purchase::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $purchase);

        if ($purchaseService->restorePurchase($purchase)) {
            $this->success(__('Record has been restored successfully'));
        } else {
            $this->error('Something went wrong.');
        }
    }

    public function destroyPayment(Payment $payment, PurchaseService $purchaseService)
    {
        $this->authorize('delete', $payment);

        if ($purchaseService->destroyPurchasePayment($payment)) {
            $this->success(__('Record has been deleted successfully'));
        } else {
            $this->error(__('Something went wrong'));
        }
    }

    public function restorePayment($id, PurchaseService $purchaseService)
    {
        $payment = Payment::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $payment);

        if ($purchaseService->restorePurchasePayment($payment)) {
            $this->success(__('Record has been restored successfully'));
        } else {
            $this->error(__('You cannot restore it. Restoring this payment would clear the entire balance.'));
        }
    }

    public function forceDeletePayment($id)
    {
        $payment = Payment::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $payment);

        // Payment status is already updated
        // When deleted the payment
        $payment->forceDelete();
        $this->success(__('Record has been deleted permanently'));
    }
}
