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
    public ?int $initial_due = null;

    public function setSupplier(Supplier $supplier)
    {
        $this->supplier = $supplier;

        $this->name = $supplier->name;
        $this->company_name = $supplier->company_name;
        $this->address = $supplier->address;
        $this->phone_number = $supplier->phone_number;
        $this->initial_due = $supplier->initial_due ?? null;
    }

    public function store()
    {
        $this->validate();

        Supplier::create([
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

        $this->supplier->update([
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
                Rule::unique(Supplier::class, 'phone_number')
                    ->ignore($this->supplier ?? null),
            ],
        ];
    }
}
