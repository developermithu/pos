<?php

namespace App\Livewire\Forms;

use App\Models\Customer;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CustomerForm extends Form
{
    public ?Customer $customer;

    public string $name = '';
    public ?string $company_name = null;
    public ?string $address = null;
    public string $phone_number = '';
    public ?int $initial_due = null;

    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;

        $this->name = $customer->name;
        $this->company_name = $customer->company_name;
        $this->address = $customer->address;
        $this->phone_number = $customer->phone_number;
        $this->initial_due = $customer->initial_due ?? null;
    }

    public function store()
    {
        $this->validate();

        Customer::create([
            'name' => $this->name,
            'company_name' => $this->company_name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'initial_due' => $this->initial_due ?? null,
        ]);
    }

    public function update()
    {
        $this->validate();

        $this->customer->update([
            'name' => $this->name,
            'company_name' => $this->company_name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'initial_due' => $this->initial_due ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'company_name' => 'nullable',
            'address' => 'nullable',
            'initial_due' => 'nullable|int|numeric|gte:0',
            'phone_number' => [
                'required',
                Rule::unique(Customer::class, 'phone_number')
                    ->ignore($this->customer ?? null),
            ],
        ];
    }
}
