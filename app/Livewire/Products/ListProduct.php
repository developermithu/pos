<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListProduct extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = "";
    public $selected = [];

    public function render()
    {
        $search = $this->search ? '%' . trim($this->search) . '%' : null;

        $searchableFields = ['name', 'sku'];

        $products = Product::query()
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->with('supplier')
            ->latest('id')
            ->paginate(25);

        return view('livewire.products.list-product', compact('products'));
    }

    public function deleteSelected()
    {
        if ($this->selected) {
            $products = Product::whereKey($this->selected);
            $products->delete();

            session()->flash('status', 'Selected records deleted successfully.');
        } else {
            session()->flash('status', 'You did not select anything.');
        }

        return back();
    }

    public function destroy(Product $product)
    {
        $product->delete();

        session()->flash('status', 'Record deleted successfully.');
        return back();
    }
}
