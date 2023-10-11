<?php

namespace App\Livewire\Forms;

use App\Models\Supplier;
use Livewire\Attributes\Rule;
use Livewire\Form;

class SupplierForm extends Form
{
    public ?Supplier $supplier;

    #[Rule('required|max:255')]
    public $name;

    #[Rule('required|max:255')]
    public $address;

    #[Rule('required|max:255')]
    public $phone_number;

    #[Rule('nullable|max:255')]
    public $bank_name;

    #[Rule('nullable|max:255')]
    public $bank_branch;

    public function setSupplier(Supplier $supplier)
    {
        $this->supplier = $supplier;

        $this->name = $supplier->name;
        $this->address = $supplier->address;
        $this->phone_number = $supplier->phone_number;
        $this->bank_name = $supplier->bank_name;
        $this->bank_branch = $supplier->bank_branch;
    }

    public function store()
    {
        $this->validate();
        Supplier::create($this->only(['name', 'address', 'phone_number', 'bank_name', 'bank_branch']));
    }

    public function update()
    {
        $this->validate();
        $this->supplier->update(
            $this->only(['name', 'address', 'phone_number', 'bank_name', 'bank_branch'])
        );
    }
}
