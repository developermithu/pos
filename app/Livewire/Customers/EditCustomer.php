<?php

namespace App\Livewire\Customers;

use App\Livewire\Forms\CustomerForm;
use App\Models\Customer;
use Livewire\Component;
use Mary\Traits\Toast;

class EditCustomer extends Component
{
    use Toast;

    public CustomerForm $form;

    public function mount(Customer $customer)
    {
        $this->authorize('update', $customer);
        $this->form->setCustomer($customer);
    }

    public function save()
    {
        $this->form->update();
        $this->success(__('Record has been updated successfully'));
        return $this->redirect(ListCustomer::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.customers.edit-customer')
            ->title(__('update customer'));
    }
}
