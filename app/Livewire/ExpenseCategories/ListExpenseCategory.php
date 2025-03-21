<?php

namespace App\Livewire\ExpenseCategories;

use App\Livewire\Forms\ExpenseCategoryForm;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Traits\SearchAndFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListExpenseCategory extends Component
{
    use SearchAndFilter, Toast, WithPagination;
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

        $expenseCategories = ExpenseCategory::select('expense_categories.id', 'expense_categories.name', 'expense_categories.details', 'expense_categories.created_at')
            ->selectRaw('(SUM(expenses.amount) / 100) as totalExpenses')
            ->leftJoin('expenses', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->whereNull('expenses.deleted_at')
            ->groupBy('expense_categories.id', 'expense_categories.name', 'expense_categories.details', 'expense_categories.created_at')
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->when($this->filterByTrash, function ($query, $value) {
                if ($value === 'onlyTrashed') {
                    $query->onlyTrashed();
                } elseif ($value === 'withTrashed') {
                    $query->withTrashed();
                }
            })
            ->latest('expense_categories.created_at')
            ->paginate(25);

        return view('livewire.expense-categories.list-expense-category', compact('expenseCategories'))
            ->title(__('expense category list'));
    }
}
