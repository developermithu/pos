<?php

namespace App\Livewire\Forms;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CategoryForm extends Form
{
    public ?Category $category;
    public string $name = '';

    public function setCategory(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
    }

    public function store()
    {
        $this->validate();
        Category::create($this->only(['name']));

        $this->reset();
    }

    public function update()
    {
        $this->validate();
        $this->category->update($this->only(['name']));
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique(Category::class)->ignore($this->category ?? null),
            ],
        ];
    }
}
