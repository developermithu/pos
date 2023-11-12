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

    #[Url(as: 'records')]
    public $filterByTrash;

    public $selected = [];

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filterByTrash', 'search'])) {
            $this->resetPage();
        }
    }

    public function clear()
    {
        $this->filterByTrash = '';
    }

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
            ->when($this->filterByTrash, function ($query, $value) {
                if ($value === "onlyTrashed") {
                    $query->onlyTrashed();
                } elseif ($value === "withTrashed") {
                    $query->withTrashed();
                }
            })
            ->latest('id')
            ->paginate(25);

        return view('livewire.products.list-product', compact('products'))->title(__('product list'));
    }

    public function deleteSelected()
    {
        if ($this->selected) {
            $products = Product::whereKey($this->selected);
            $products->delete();

            session()->flash('status', __('Selected records has been deleted'));
        } else {
            session()->flash('status', __('You did not select anything'));
        }

        return back();
    }

    public function destroy(Product $product)
    {
        $product->delete();

        session()->flash('status', __('Record has been deleted successfully'));
        return back();
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        session()->flash('status', __('Record has been deleted permanently'));
        return back();
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        session()->flash('status', __('Record has been restored successfully'));
        return back();
    }
}
