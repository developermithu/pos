<?php

namespace App\Livewire\Purchases;

use App\Models\Purchase;
use Livewire\Component;

class ShowPurchase extends Component
{
    public Purchase $purchase;

    public function mount(Purchase $purchase)
    {
        $this->authorize('view', $purchase);
        $this->purchase = $purchase->load('items.product');
    }

    public function render()
    {
        return view('livewire.purchases.show-purchase')
            ->title(__('purchase details'));
    }
}
