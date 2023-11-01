<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;

class CreateProduct extends Component
{
    public $supplier_id = '';
    public $name;
    public $qty;
    public $buying_date;
    public $expire_date;
    public $buying_price;
    public $selling_price;

    public function save()
    {
        $this->validate();

        Product::create([
            'supplier_id' => $this->supplier_id,
            'name' => $this->name,
            'qty' => $this->qty,
            'buying_date' => $this->buying_date == "" ? null : $this->buying_date,
            'expire_date' => $this->expire_date == "" ? null : $this->expire_date,
            'buying_price' => $this->buying_price,
            'selling_price' => $this->selling_price,
        ]);

        session()->flash('status', 'Record created successfully.');
        return $this->redirect(ListProduct::class, navigate: true);
    }

    public function render()
    {
        $suppliers = Supplier::pluck('name', 'id');
        return view('livewire.products.create-product', compact('suppliers'));
    }

    public function rules(): array
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string',
            'qty' => 'required|integer',
            'buying_date' => 'nullable|date|date_format:Y-m-d',
            'expire_date' => 'nullable|date|date_format:Y-m-d|after:buying_date',
            'buying_price' => 'nullable|numeric',
            'selling_price' => 'nullable|numeric',
        ];
    }
}
