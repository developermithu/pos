<?php

namespace App\Livewire\Suppliers;

use App\Livewire\Forms\SupplierForm;
use App\Models\Supplier;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateSupplier extends Component
{
    use Toast;

    public SupplierForm $form;

    public function mount()
    {
        $this->authorize('create', Supplier::class);
    }

    public function save()
    {
        $this->form->store();

        $this->success(__('Record has been created successfully'));
        return $this->redirect(ListSupplier::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.suppliers.create-supplier')
            ->title(__('add new supplier'));
    }
}
