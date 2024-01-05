<?php

namespace App\Livewire\Pos;

use App\Models\Sale;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateInvoice extends Component
{
    use Toast;

    public Sale $sale;

    public function mount($invoice_no)
    {
        $this->sale = Sale::whereInvoiceNo($invoice_no)->firstOrFail();
        $this->authorize('createInvoice', Sale::class);
    }

    public function render()
    {
        return view('livewire.pos.create-invoice')->title(__('create invoice'));
    }
}
