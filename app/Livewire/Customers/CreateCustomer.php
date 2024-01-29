<?php

namespace App\Livewire\Customers;

use App\Livewire\Forms\CustomerForm;
use App\Models\Customer;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateCustomer extends Component
{
    use Toast;

    public CustomerForm $form;

    public function mount()
    {
        $this->authorize('create', Customer::class);
    }

    public function save()
    {
        $this->form->store();
        $this->success(__('Record has been created successfully'));

        return $this->redirect(ListCustomer::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.customers.create-customer')->title(__('add new customer'));
    }
}
