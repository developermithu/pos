<?php

namespace App\Livewire\Sales;

use App\Models\Payment;
use App\Models\Sale;
use App\Services\SaleService;
use App\Traits\SearchAndFilter;
use Illuminate\Database\Eloquent\Builder;
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
            ->when($this->filterByTrash, function ($query, $value) {
                if ($value === 'onlyTrashed') {
                    $query->onlyTrashed();
                } elseif ($value === 'withTrashed') {
                    $query->withTrashed();
                }
            })
            ->with('customer:id,name', 'payments', 'payments.account:id,name')
            ->withSum(['payments' => function (Builder $query) {
                $query->whereNull('deleted_at');
            }], 'amount')
            ->latest('id')
            ->paginate(20);

        return view('livewire.sales.list-sale', compact('sales'))
            ->title(__('sale list'));
    }

    public function deleteSelected(SaleService $saleService)
    {
        $this->authorize('bulkDelete', Sale::class);

        if ($this->selected) {
            if ($saleService->bulkDeleteSales($this->selected)) {
                $this->success(__('Selected records have been deleted'));
            } else {
                $this->error(__('Something went wrong'));
            }
        } else {
            $this->success(__('You did not select anything'));
        }
    }

    public function destroy(Sale $sale, SaleService $saleService)
    {
        $this->authorize('delete', $sale);

        if ($saleService->deleteSale($sale)) {
            $this->success(__('Record has been deleted successfully'));
        } else {
            $this->error('Something went wrong.');
        }
    }

    public function forceDelete($id, SaleService $saleService)
    {
        $sale = Sale::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $sale);

        if ($saleService->forceDeleteSale($sale)) {
            $this->success(__('Record has been deleted permanently'));
        } else {
            $this->error('Something went wrong.');
        }
    }

    public function restore($id, SaleService $saleService)
    {
        $sale = Sale::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $sale);

        if ($saleService->restoreSale($sale)) {
            $this->success(__('Record has been restored successfully'));
        } else {
            $this->error('Something went wrong.');
        }
    }

    public function destroyPayment(Payment $payment, SaleService $saleService)
    {
        $this->authorize('delete', $payment);

        if ($saleService->destroySalePayment($payment)) {
            $this->success(__('Record has been deleted successfully'));
        } else {
            $this->error(__('Something went wrong.'));
        }
    }

    public function restorePayment($id, SaleService $saleService)
    {
        $payment = Payment::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $payment);

        if ($saleService->restoreSalePayment($payment)) {
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
