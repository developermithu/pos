<?php

namespace App\Livewire\ExpenseCategories;

use App\Livewire\Forms\ExpenseCategoryForm;
use App\Models\ExpenseCategory;
use App\Traits\SearchAndFilter;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListExpenseCategory extends Component
{
    use WithPagination, Toast, SearchAndFilter;
    public ExpenseCategoryForm $form;

    public function create()
    {
        $this->authorize('create', ExpenseCategory::class);
        $this->form->store();

        $this->success(__('Record has been created successfully'));
        $this->dispatch('close');
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        $this->authorize('delete', $expenseCategory);

        $expenseCategory->delete();
        $this->success(__('Record has been deleted successfully'));
        return back();
    }

    public function forceDelete($id)
    {
        $expenseCategory = ExpenseCategory::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $expenseCategory);

        $expenseCategory->forceDelete();
        $this->success(__('Record has been deleted permanently'));

        return back();
    }

    public function restore($id)
    {
        $expenseCategory = ExpenseCategory::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $expenseCategory);
        $expenseCategory->restore();

        $this->success(__('Record has been restored successfully'));
        return back();
    }

    public function render()
    {
        $this->authorize('viewAny', ExpenseCategory::class);

        $search = $this->search ? '%' . trim($this->search) . '%' : null;
        $searchableFields = ['name'];

        $expenseCategories = ExpenseCategory::query()
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->when($this->filterByTrash, function ($query, $value) {
                if ($value === "onlyTrashed") {
                    $query->onlyTrashed();
                } elseif ($value === "withTrashed") {
                    $query->withTrashed();
                }
            })
            ->latest()
            ->paginate(20);

        return view('livewire.expense-categories.list-expense-category', compact('expenseCategories'))
            ->title(__('expense category list'));
    }
}
