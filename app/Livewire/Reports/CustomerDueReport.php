<?php

namespace App\Livewire\Reports;

use App\Enums\SalePaymentStatus;
use App\Models\Sale;
use App\Traits\SearchAndFilter;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerDueReport extends Component
{
    use SearchAndFilter, WithPagination;

    public $status = [];

    #[Url('start_date')]
    public $start_date;

    #[Url('end_date')]
    public $end_date;

    public $customer_id = '';

    public function render()
    {
        $this->authorize('viewAny', Sale::class);
        $search = $this->search ? '%'.trim($this->search).'%' : null;

        $sales = Sale::query()
            ->where('payment_status', '!=', SalePaymentStatus::PAID)
            ->when($this->status, function ($query) {
                $query->whereIn('status', $this->status);
            })
            ->when($this->start_date && $this->end_date, function ($query) {
                $query->whereBetween('date', [$this->start_date, $this->end_date]);
            })
            ->when($this->customer_id, function ($query) {
                $query->where('customer_id', $this->customer_id);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('invoice_no', 'like', $search);
                $query->orWhere('status', 'like', $search)
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('name', 'like', $search);
                    })
                    ->orWhereHas('items.product', function ($query) use ($search) {
                        $query->where('name', 'like', $search);
                    });
            })
            ->with(['customer:id,name', 'items.product:id,name,unit_id', 'items.product.unit:id,short_name'])
            ->latest()
            ->paginate(20);

        return view('livewire.reports.customer-due-report', compact('sales'))
            ->title(__('customer due report'));
    }

    public function clear()
    {
        $this->status = [];
        $this->search = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->customer_id = '';
    }
}
