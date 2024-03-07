<?php

namespace App\Livewire\Products;

use App\Enums\ProductType;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateProduct extends Component
{
    use Toast;

    public ?int $category_id = null;
    public ?int $unit_id = null;
    public string $name;
    public ?int $qty;
    public int $cost;
    public int $price;
    public string $type;

    public ?int $purchase_unit_id = null;
    public ?int $sale_unit_id = null;

    public $sale_units = null;
    public $purchase_units = null;

    public function mount()
    {
        $this->authorize('create', Product::class);
        $this->type = ProductType::STANDARD->value;
    }

    public function render()
    {
        $baseUnits = Unit::whereUnitId(null)->pluck('name', 'id');

        return view('livewire.products.create-product', compact('baseUnits'))
            ->title(__('add new product'));
    }

    public function updatedUnitId()
    {
        $units = Unit::whereId($this->unit_id)
            ->orWhere('unit_id', $this->unit_id)
            ->pluck('name', 'id');

        $this->sale_units = $this->purchase_units = $units;

        if (is_null($this->unit_id)) {
            $this->sale_units = $this->purchase_units = null;
        }
    }

    public function updatedType()
    {
        $this->purchase_unit_id = null;
        $this->sale_unit_id = null;
        $this->cost = null;
    }

    public function save()
    {
        $this->validate();

        Product::create([
            'category_id' => $this->category_id ?? null,
            'unit_id' => $this->unit_id,
            'name' => $this->name,
            'qty' => $this->qty ?? null,
            'price' => $this->price,
            'type' => $this->type,

            'cost' => $this->cost ?? null,
            'sale_unit_id' => $this->sale_unit_id ?? null,
            'purchase_unit_id' => $this->purchase_unit_id ?? null,
        ]);

        $this->success(__('Record has been created successfully'));

        return $this->redirect(ListProduct::class, navigate: true);
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
            'cost' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'type' => ['required', Rule::enum(ProductType::class)],
        ];

        if ($this->type === ProductType::STANDARD->value) {
            $rules['sale_unit_id'] = ['required', Rule::exists(Unit::class, 'id')];
            $rules['purchase_unit_id'] = ['required', Rule::exists(Unit::class, 'id')];
        }

        return $rules;
    }
}
