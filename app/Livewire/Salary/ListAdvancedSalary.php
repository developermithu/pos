<?php

namespace App\Livewire\Salary;

use App\Models\AdvancedSalary;
use App\Models\Employee;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListAdvancedSalary extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = "";
    public $selected = [];

    public function deleteSelected()
    {
        $advanced_salary = AdvancedSalary::whereKey($this->selected);
        $advanced_salary->delete();

        session()->flash('status', __('Selected records has been deleted'));
        return back();
    }

    public function destroy(AdvancedSalary $advanced_salary)
    {
        $advanced_salary->delete();

        session()->flash('status', __('Record has been deleted successfully'));
        return back();
    }

    public function render()
    {
        $search = $this->search ? '%' . trim($this->search) . '%' : null;

        $searchableFields = ['month', 'year'];

        $advanced_salaries = AdvancedSalary::query()
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->with('employee')
            ->latest()
            ->paginate(10);

        return view('livewire.salary.list-advanced-salary', compact('advanced_salaries'))
            ->title(__('advanced salary list'));
    }
}
