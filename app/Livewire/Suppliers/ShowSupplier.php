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
            ->with('payments')
            ->get()
            ->flatMap(function ($sale) {
                return $sale->payments->whereNull('deleted_at');
            })
            ->sortByDesc('created_at');

        return view('livewire.suppliers.show-supplier', compact('payments'))
            ->title(__('supplier details'));
    }
}
