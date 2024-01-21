<?php

namespace App\Livewire\Reports;

use App\Enums\PurchasePaymentStatus;
use App\Models\Purchase;
use App\Traits\SearchAndFilter;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SupplierDueReport extends Component
{
    use WithPagination, SearchAndFilter;

    public $status = [];

    #[Url('start_date')]
    public $start_date;

    #[Url('end_date')]
    public $end_date;

    public $supplier_id = '';

    public function render()
    {
        $this->authorize('viewAny', Purchase::class);
        $search = $this->search ? '%' . trim($this->search) . '%' : null;

        $sales = Purchase::query()
            ->where('payment_status', '!=', PurchasePaymentStatus::PAID)
            ->when($this->status, function ($query) {
                $query->whereIn('status', $this->status);
            })
            ->when($this->start_date && $this->end_date, function ($query) {
                $query->whereBetween('date', [$this->start_date, $this->end_date]);
            })
            ->when($this->supplier_id, function ($query) {
                $query->where('supplier_id', $this->supplier_id);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('invoice_no', 'like', $search);
                $query->orWhere('status', 'like', $search)
                    ->orWhereHas('supplier', function ($query) use ($search) {
                        $query->where('name', 'like', $search);
                    })
                    ->orWhereHas('items.product', function ($query) use ($search) {
                        $query->where('name', 'like', $search);
                    });
            })
            ->with(['supplier:id,name', 'items.product:id,name,unit_id', 'items.product.unit:id,short_name'])
            ->latest()
            ->paginate(20);

        return view('livewire.reports.supplier-due-report', compact('sales'))
            ->title(__('supplier due report'));
    }

    public function clear()
    {
        $this->status = [];
        $this->search = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->supplier_id = '';
    }
}
