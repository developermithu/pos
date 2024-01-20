<?php

namespace App\Livewire\Forms;

use App\Models\Supplier;
use Illuminate\Validation\Rule;
use Livewire\Form;

class SupplierForm extends Form
{
    public ?Supplier $supplier;

    public string $name = '';
    public ?string $company_name = null;
    public ?string $address = null;
    public string $phone_number = '';

    public function setSupplier(Supplier $supplier)
    {
        $this->supplier = $supplier;

        $this->name = $supplier->name;
        $this->company_name = $supplier->company_name;
        $this->address = $supplier->address;
        $this->phone_number = $supplier->phone_number;
    }

    public function store()
    {
        $this->validate();

        Supplier::create(
            $this->only(
                [
                    'name',
                    'company_name',
                    'address',
                    'phone_number'
                ]
            )
        );
    }

    public function update()
    {
        $this->validate();

        $this->supplier->update(
            $this->only(
                [
                    'name',
                    'company_name',
                    'address',
                    'phone_number'
                ]
            )
        );
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'company_name' => 'nullable',
            'address' => 'nullable',
            'phone_number' => [
                'required',
                Rule::unique(Supplier::class, 'phone_number')
                    ->ignore($this->supplier ?? null)
            ],
        ];
    }
}
