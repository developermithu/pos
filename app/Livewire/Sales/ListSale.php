<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Livewire\Component;

class ListSale extends Component
{
    public function render()
    {
        $sales = Sale::with('customer')->paginate(20);

        return view('livewire.sales.list-sale', compact('sales'))->title(__('sale list'));
    }
}
