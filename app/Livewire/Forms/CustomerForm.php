<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CustomerForm extends Form
{
    public ?Customer $customer;

    public string $name = '';
    public ?string $company_name = null;
    public ?string $address = null;
    public string $phone_number = '';

    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;

        $this->name = $customer->name;
        $this->company_name = $customer->company_name;
        $this->address = $customer->address;
        $this->phone_number = $customer->phone_number;
    }

    public function store()
    {
        $this->validate();
        Customer::create($this->only(['name', 'company_name', 'address', 'phone_number']));

        $this->reset();
    }

    public function update()
    {
        $this->validate();
        $this->customer->update($this->only(['name', 'company_name', 'address', 'phone_number']));
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'company_name' => 'nullable',
            'address' => 'nullable',
            'phone_number' => [
                'required',
                Rule::unique(Customer::class, 'phone_number')
                    ->ignore($this->customer ?? null)
            ],
        ];
    }
}
