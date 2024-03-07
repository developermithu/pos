<?php

namespace App\Livewire\Forms;

use App\Models\ExpenseCategory;
use Illuminate\Validation\Rule;
use Livewire\Form;

class ExpenseCategoryForm extends Form
{
    public ?ExpenseCategory $expenseCategory;

    public string $name = '';
    public ?string $details = '';

    public function setExpenseCategory(ExpenseCategory $expenseCategory)
    {
        $this->expenseCategory = $expenseCategory;

        $this->name = $expenseCategory->name;
        $this->details = $expenseCategory->details ?? null;
    }

    public function store()
    {
        $this->validate();
        ExpenseCategory::create($this->only(['name', 'details']));

        $this->reset();
    }

    public function update()
    {
        $this->validate();
        $this->expenseCategory->update(
            $this->only(['name', 'details'])
        );
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique(ExpenseCategory::class)->ignore($this->expenseCategory ?? null),
            ],

            'details' => 'nullable|min:255',
        ];
    }
}
