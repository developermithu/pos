<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Traits\SearchAndFilter;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Lazy]
class ListProduct extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    public $selected = [];

    public function render()
    {
        $this->authorize('viewAny', Product::class);

        $search = $this->search ? '%'.trim($this->search).'%' : null;
        $searchableFields = ['name', 'sku'];

        $products = Product::query()
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->with('category:id,name', 'unit:id,short_name')
            ->when($this->filterByTrash, function ($query, $value) {
                if ($value === 'onlyTrashed') {
                    $query->onlyTrashed();
                } elseif ($value === 'withTrashed') {
                    $query->withTrashed();
                }
            })
            ->latest('id')
            ->paginate(20);

        return view('livewire.products.list-product', compact('products'))->title(__('product list'));
    }

    public function deleteSelected()
    {
        $this->authorize('bulkDelete', Product::class);

        if ($this->selected) {
            Product::destroy($this->selected);
            $this->success(__('Selected records has been deleted'));
        } else {
            $this->success(__('You did not select anything'));
        }

        return back();
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();

        $this->success(__('Record has been deleted successfully'));

        return back();
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $product);
        $product->forceDelete();

        $this->success(__('Record has been deleted permanently'));

        return back();
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $product);
        $product->restore();

        $this->success(__('Record has been restored successfully'));

        return back();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.product-page');
    }
}
