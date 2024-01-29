<?php

namespace App\Livewire\Forms;

use App\Models\ExpenseCategory;
use Illuminate\Validation\Rule;
use Livewire\Form;

class ExpenseCategoryForm extends Form
{
    public ?ExpenseCategory $expenseCategory;

    public string $name = '';
    public ?string $description = '';

    public function setExpenseCategory(ExpenseCategory $expenseCategory)
    {
        $this->expenseCategory = $expenseCategory;

        $this->name = $expenseCategory->name;
        $this->description = $expenseCategory->description ?? null;
    }

    public function store()
    {
        $this->validate();
        ExpenseCategory::create($this->only(['name', 'description']));

        $this->reset();
    }

    public function update()
    {
        $this->validate();
        $this->expenseCategory->update(
            $this->only(['name', 'description'])
        );
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique(ExpenseCategory::class)->ignore($this->expenseCategory ?? null),
            ],

            'description' => 'nullable|max:255',
        ];
    }
}
