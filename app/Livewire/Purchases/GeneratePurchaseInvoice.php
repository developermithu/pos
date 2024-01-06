<?php

namespace App\Livewire\Purchases;

use App\Models\Purchase;
use Livewire\Component;
use Mary\Traits\Toast;

class GeneratePurchaseInvoice extends Component
{
    public Purchase $purchase;

    public function mount($invoice_no)
    {
        $this->purchase = Purchase::whereInvoiceNo($invoice_no)->firstOrFail();
        $this->authorize('createInvoice', Purchase::class);
    }

    public function render()
    {
        return view('livewire.purchases.generate-purchase-invoice')
            ->title(__('generate purchase invoice'));
    }
}
