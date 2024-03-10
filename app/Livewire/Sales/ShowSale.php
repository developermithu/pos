<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Livewire\Component;

class ShowSale extends Component
{
    public Sale $sale;

    public function mount(Sale $sale)
    {
        $this->authorize('view', $sale);
        $this->sale = $sale->load('items.product');
    }

    public function render()
    {
        return view('livewire.sales.show-sale')->title(__('sale details'));
    }
}
