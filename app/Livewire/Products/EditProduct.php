<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Supplier;
use Livewire\Component;

class EditProduct extends Component
{
    public $product;

    public $supplier_id = '';
    public $name;
    public $sku;
    public $qty;
    public $buying_date;
    public $expired_date;
    public $buying_price;
    public $selling_price;

    public function mount(Product $product)
    {
        $this->product = $product;

        $this->supplier_id = $product->supplier_id;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->qty = $product->qty;
        $this->buying_date = $product->buying_date ? $product->buying_date->format('Y-m-d') : NULL;
        $this->expired_date = $product->expired_date ? $product->expired_date->format('Y-m-d') : NULL;
        $this->buying_price = $product->buying_price;
        $this->selling_price = $product->selling_price;
    }

    public function save()
    {
        $this->validate();

        $this->product->update([
            'supplier_id' => $this->supplier_id,
            'name' => $this->name,
            'qty' => $this->qty,
            'buying_date' => $this->buying_date == "" ? null : $this->buying_date,
            'expired_date' => $this->expired_date == "" ? null : $this->expired_date,
            'buying_price' => $this->buying_price,
            'selling_price' => $this->selling_price,
        ]);

        session()->flash('status', __('Record has been updated successfully'));
        return $this->redirect(ListProduct::class, navigate: true);
    }

    public function render()
    {
        $suppliers = Supplier::pluck('name', 'id');
        return view('livewire.products.edit-product', compact('suppliers'))->title(__('update product'));
    }

    public function rules(): array
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'name' => 'required|string',
            'qty' => 'required|integer',
            'buying_date' => 'nullable|date|date_format:Y-m-d',
            'expired_date' => 'nullable|date|date_format:Y-m-d|after:buying_date',
            'buying_price' => 'nullable|integer',
            'selling_price' => 'nullable|integer',
        ];
    }
}
