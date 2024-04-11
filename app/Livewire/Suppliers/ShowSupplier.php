<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class ShowSupplier extends Component
{
    public Supplier $supplier;

    public function mount(Supplier $supplier)
    {
        $this->authorize('view', $supplier);
        $this->supplier = $supplier->load('purchases', 'deposits');
    }

    public function render()
    {
        $payments = $this->supplier->purchases()
            ->with(['payments' => function ($query) {
                $query->with('account:id,name')->whereNull('deleted_at');
            }])
            ->get()
            ->flatMap(function ($sale) {
                return $sale->payments;
            })
            ->sortByDesc('created_at');

        return view('livewire.suppliers.show-supplier', compact('payments'))
            ->title(__('supplier details'));
    }
}
