<?php

namespace App\Livewire\Products;

use App\Enums\ProductType;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class EditProduct extends Component
{
    use Toast;

    public $product;

    public ?int $category_id = null;
    public ?int $unit_id = null;
    public string $name;
    public string $sku;
    public ?int $qty;
    public int $price;
    public $type;

    public ?int $purchase_unit_id = null;
    public ?int $sale_unit_id = null;
    public ?int $purchase_price = null;
    public ?int $sale_price = null;
    public ?int $cost = null;

    public $sale_units = null;
    public $purchase_units = null;

    public function mount(Product $product)
    {
        $this->authorize('update', $product);

        $this->product = $product;

        $this->category_id = $product->category_id ?? null;
        $this->unit_id = $product->unit_id;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->qty = $product->qty;
        $this->price = $product->price;
        $this->type = $product->type;

        $this->cost = $product->cost;
        $this->sale_price = $product->sale_price;
        $this->purchase_price = $product->purchase_price;
        $this->sale_unit_id = $product->sale_unit_id ?? null;
        $this->purchase_unit_id = $product->purchase_unit_id ?? null;

        $units = Unit::whereId($this->unit_id)
            ->orWhere('unit_id', $this->unit_id)
            ->pluck('name', 'id');

        $this->sale_units = $this->purchase_units = $units;
    }

    public function save()
    {
        $this->validate();

        $this->product->update([
            'category_id' => $this->category_id ?? null,
            'unit_id' => $this->unit_id,
            'name' => $this->name,
            'qty' => $this->qty ?? null,
            'price' => $this->price,

            'cost' => $this->cost ?? null,
            'sale_price' => $this->sale_price ?? null,
            'purchase_price' => $this->purchase_price ?? null,
            'sale_unit_id' => $this->sale_unit_id ?? null,
            'purchase_unit_id' => $this->purchase_unit_id ?? null,
        ]);

        $this->success(__('Record has been updated successfully'));

        return $this->redirect(ListProduct::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.products.edit-product')->title(__('update product'));
    }

    public function updatedUnitId()
    {
        $this->sale_unit_id = $this->purchase_unit_id = null;

        $units = Unit::whereId($this->unit_id)
            ->orWhere('unit_id', $this->unit_id)
            ->pluck('name', 'id');

        $this->sale_units = $this->purchase_units = $units;

        if (is_null($this->unit_id)) {
            $this->sale_units = $this->purchase_units = null;
        }
    }

    public function rules(): array
    {
        $rules = [
            'category_id' => [
                'nullable',
                Rule::exists(Category::class, 'id')->when($this->category_id, function ($query) {
                    return $query;
                }),
            ],
            'unit_id' => ['required', Rule::exists(Unit::class, 'id')],
            'name' => ['required', 'string'],
            'qty' => ['nullable', 'numeric'],
            'price' => ['required', 'numeric'],
        ];

        if ($this->type === ProductType::STANDARD) {
            $rules['cost'] = ['required', 'numeric'];
            $rules['sale_price'] = ['required', 'numeric'];
            $rules['purchase_price'] = ['required', 'numeric'];
            $rules['sale_unit_id'] = ['required', Rule::exists(Unit::class, 'id')];
            $rules['purchase_unit_id'] = ['required', Rule::exists(Unit::class, 'id')];
        }

        return $rules;
    }
}
