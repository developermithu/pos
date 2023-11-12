<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;

class EditCustomer extends Component
{
    public $customer;

    public string $name;
    public string $address;
    public string $phone_number;
    public $due;
    public $advanced_paid;

    public function mount(Customer $customer)
    {
        $this->customer = $customer;

        $this->name = $customer->name;
        $this->address = $customer->address;
        $this->phone_number = $customer->phone_number;
        $this->due = $customer->due;
        $this->advanced_paid = $customer->advanced_paid;
    }

    public function save()
    {
        $this->validate();

        $this->customer->update([
            'name' => $this->name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'due' => $this->due,
            'advanced_paid' => $this->advanced_paid
        ]);

        session()->flash('status', __('Record has been updated successfully'));
        return $this->redirect(ListCustomer::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.customers.edit-customer')->title(__('update customer'));
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:customers,name,' . $this->customer->id,
            'address' => 'required',
            'phone_number' => 'required',
            'due' => 'nullable|numeric',
            'advanced_paid' => 'nullable|numeric',
        ];
    }
}
