<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateProduct extends Component
{
    use Toast;

    public int|string $category_id = '';
    public int|string $unit_id = '';
    public string $name;
    public ?int $qty;
    public ?int $cost;
    public int $price;

    public function mount()
    {
        $this->authorize('create', Product::class);
    }

    public function save()
    {
        $this->validate();

        $category_is_null = $this->category_id === '' || $this->category_id === null;

        Product::create([
            'category_id' => $category_is_null ? null : $this->category_id,
            'unit_id' => $this->unit_id,
            'name' => $this->name,
            'qty' => $this->qty ?? null,
            'cost' => $this->cost ?? null,
            'price' => $this->price,
        ]);

        $this->success(__('Record has been created successfully'));

        return $this->redirect(ListProduct::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.products.create-product')->title(__('add new product'));
    }

    public function rules(): array
    {
        return [
            'category_id' => [
                'nullable',
                Rule::exists(Category::class, 'id')->when($this->category_id, function ($query) {
                    return $query;
                }),
            ],
            'unit_id' => [
                'required',
                Rule::exists(Unit::class, 'id'),
            ],
            'name' => 'required|string',
            'qty' => 'nullable|numeric',
            'cost' => 'nullable|numeric',
            'price' => 'required|numeric',
        ];
    }
}
