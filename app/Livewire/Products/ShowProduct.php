<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class ShowProduct extends Component
{
    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.products.show-product')->title(__($this->product->name));
    }
}
