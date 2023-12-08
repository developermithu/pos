<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateCustomer extends Component
{
    use Toast;

    public string $name;
    public string $address;
    public string $phone_number;
    public ?int $due;
    public ?int $advanced_paid;

    public function mount()
    {
        $this->authorize('create', Customer::class);
    }

    public function save()
    {
        $this->validate();

        Customer::create([
            'name' => $this->name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'due' => $this->due,
            'advanced_paid' => $this->advanced_paid
        ]);

        $this->success(__('Record has been created successfully'));
        return $this->redirect(ListCustomer::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.customers.create-customer')->title(__('add new customer'));
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:customers,name',
            'address' => 'required',
            'phone_number' => 'required',
            'due' => 'nullable|numeric',
            'advanced_paid' => 'nullable|numeric',
        ];
    }
}
