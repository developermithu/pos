<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use App\Traits\SearchAndFilter;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListExpense extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    public $selected = [];

    #[Url('date')]
    public $selectedTimePeriod = '';

    public function render()
    {
        $this->authorize('viewAny', Expense::class);

        $search = $this->search ? '%'.trim($this->search).'%' : null;
        $searchableFields = ['details'];

        $expenses = Expense::query()
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
            ->when($this->selectedTimePeriod, function ($query, $value) {
                if ($value === 'todays') {
                    $query->whereDate('created_at', now()->today());
                } elseif ($value === 'monthly') {
                    $query->whereMonth('created_at', now()->month);
                    $query->whereYear('created_at', now()->year);
                } elseif ($value === 'yearly') {
                    $query->whereYear('created_at', now()->year);
                }
            })
            ->latest()
            ->paginate(10);

        $todaysTotalExpense = Expense::whereDate('created_at', now()->today())->sum('amount') / 100;
        $monthlyTotalExpense = Expense::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount') / 100;
        $yearlyTotalExpense = Expense::whereYear('created_at', now()->year)->sum('amount') / 100;
        $totalExpense = Expense::sum('amount') / 100;

        return view('livewire.expenses.list-expense', compact('expenses', 'todaysTotalExpense', 'monthlyTotalExpense', 'yearlyTotalExpense', 'totalExpense'))
            ->title(__('expense list'));
    }

    public function deleteSelected()
    {
        $this->authorize('bulkDelete', Expense::class);

        if ($this->selected) {
            Expense::destroy($this->selected);
            $this->success(__('Selected records has been deleted'));
        } else {
            $this->success(__('You did not select anything'));
        }

        return back();
    }

    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);
        $expense->delete();

        $this->success(__('Record has been deleted successfully'));

        return back();
    }

    public function forceDelete($id)
    {
        $expense = Expense::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $expense);

        try {
            DB::beginTransaction();

            // Delete associated payment
            $expense->payment()->forceDelete();
            $expense->forceDelete();

            DB::commit();
            $this->success(__('Record has been deleted permanently'));
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Error force deleting expense: '.$e->getMessage());
            $this->error(__('Something went wrong!'));
        }

        return back();
    }

    public function restore($id)
    {
        $expense = Expense::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $expense);
        $expense->restore();

        $this->success(__('Record has been restored successfully'));

        return back();
    }

    public function filterByTimePeriod($timePeriod)
    {
        $this->selectedTimePeriod = $timePeriod;
    }
}
