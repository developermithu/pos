<?php

namespace App\Livewire\Suppliers;

use App\Livewire\Forms\SupplierForm;
use App\Models\Supplier;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateSupplier extends Component
{
    public SupplierForm $form;

    public function save()
    {
        $this->form->store();
        return $this->redirect(ListSupplier::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.suppliers.create-supplier')
            ->title(__('add new supplier'));
    }
}
