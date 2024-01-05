<?php

namespace App\Livewire\Sales;

use App\Livewire\Forms\PaymentForm;
use App\Models\Payment;
use App\Models\Sale;
use Livewire\Component;
use Mary\Traits\Toast;

class AddSalePayment extends Component
{
    use Toast;

    public PaymentForm $form;

    public function mount(Sale $sale)
    {
        $this->authorize('update', $sale);

        $this->form->setSale($sale);

        $dueAmount = $sale->total - $sale->paid_amount;

        if ($dueAmount <= 0) {
            abort(403);
        }

        $this->form->received_amount = $dueAmount;
        $this->form->paid_amount     = $dueAmount;
    }

    // Add Payment
    public function addPayment()
    {
        $this->authorize('create', Payment::class);
        $this->form->store();

        $this->success(__('Record has been created successfully'));
        return back();
    }

    public function render()
    {
        return view('livewire.sales.add-sale-payment');
    }
}
