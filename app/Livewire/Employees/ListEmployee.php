<?php

namespace App\Livewire\Employees;

use App\Models\Employee;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListEmployee extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = "";

    #[Url(as: 'records')]
    public $filterByTrash;

    public $selected = [];

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filterByTrash', 'search'])) {
            $this->resetPage();
        }
    }

    public function clear()
    {
        $this->filterByTrash = '';
    }

    public function deleteSelected()
    {
        $this->authorize('bulkDelete', Employee::class);

        $employees = Employee::whereKey($this->selected);
        $employees->delete();

        session()->flash('status', __('Selected records has been deleted'));
        return back();
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);
        $employee->delete();

        session()->flash('status', __('Record has been deleted successfully'));
        return back();
    }

    public function forceDelete($id)
    {
        $employee = Employee::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $employee);
        $employee->forceDelete();

        session()->flash('status', __('Record has been deleted permanently'));
        return back();
    }

    public function restore($id)
    {
        $employee = Employee::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $employee);
        $employee->restore();

        session()->flash('status', __('Record has been restored successfully'));
        return back();
    }

    public function render()
    {
        $this->authorize('viewAny', Employee::class);

        $search = $this->search ? '%' . trim($this->search) . '%' : null;

        $searchableFields = ['name', 'father_name', 'address', 'phone_number', 'salary', 'gender'];

        $employees = Employee::query()
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
            ->paginate(10);


        return view('livewire.employees.list-employee', compact('employees'))->title(__('employee list'));
    }
}
