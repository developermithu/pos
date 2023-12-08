<?php

namespace App\Livewire\Suppliers;

use App\Livewire\Forms\SupplierForm;
use App\Models\Supplier;
use Livewire\Component;
use Mary\Traits\Toast;

class EditSupplier extends Component
{
    use Toast;

    public SupplierForm $form;

    public function mount(Supplier $supplier)
    {
        $this->authorize('update', $supplier);
        $this->form->setSupplier($supplier);
    }

    public function save()
    {
        $this->form->update();

        $this->success(__('Record has been updated successfully'));
        return $this->redirect(ListSupplier::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.suppliers.edit-supplier')
            ->title(__('update supplier'));
    }
}
