<?php

namespace App\Livewire\Pos;

use App\Models\Sale;
use Livewire\Component;

class CreateInvoice extends Component
{
    public Sale $sale;

    public function mount($invoice_no)
    {
        $this->sale = Sale::whereInvoiceNo($invoice_no)->firstOrFail();
        $this->authorize('createInvoice', Sale::class);
    }

    public function render()
    {
        return view('livewire.pos.create-invoice')->title(__('create sale invoice'));
    }
}
