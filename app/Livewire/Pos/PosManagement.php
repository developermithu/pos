<?php

namespace App\Livewire\Pos;

use App\Models\Customer;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class PosManagement extends Component
{
    use WithPagination, Toast;

    public $perPage = 10;

    #[Url(as: 'q')]
    public string $search = "";

    #[Rule('required|exists:customers,id', as: 'customer name')]
    public $customer_id;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->authorize('posManagement', Product::class);
    }

    public function render()
    {
        $this->authorize('viewPos', Product::class);

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
            ->latest('id')
            ->paginate($this->perPage);

        return view('livewire.pos.pos-management', compact('products'))->title(__('pos'));
    }

    public function addToCart(Product $product)
    {
        Cart::add(
            $product->id,
            $product->name,
            1,
            $product->selling_price ? $product->selling_price : $product->buying_price,
        )->associate(Product::class);

        $this->success(__('Product added successfully.'));
        return back();
    }

    public function increaseQty($rowId)
    {
        $item = Cart::get($rowId);
        Cart::update($rowId, $item->qty + 1);

        $this->success(__('Quantity increased.'));
        return back();
    }

    public function decreaseQty($rowId)
    {
        $item = Cart::get($rowId);

        if ($item->qty === 1) {
            Cart::remove($rowId);
            $this->success(__('Item removed.'));
        } else {
            Cart::update($rowId, $item->qty - 1);
            $this->success(__('Quantity decreased.'));
        }

        return back();
    }

    public function removeFromCart($rowId)
    {
        Cart::remove($rowId);

        $this->success(__('Item removed.'));
        return back();
    }

    public function createInvoice()
    {
        $this->validate();

        $customer = Customer::findOrFail($this->customer_id);

        session()->put('customer', [
            'id' => $customer->id,
            'name' => $customer->name,
            'address' => $customer->address,
            'phone_number' => $customer->phone_number,
            'due' => $customer->due,
            'advanced_paid' => $customer->advanced_paid,
        ]);

        session()->put('invoice_no', rand(111111, 999999));

        return $this->redirect(CreateInvoice::class, navigate: true);
    }
}
