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
    public $selected = [];

    public function deleteSelected()
    {
        $employees = Employee::whereKey($this->selected);
        $employees->delete();

        session()->flash('status', 'Selected records deleted successfully.');
        return back();
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        session()->flash('status', 'Record deleted successfully.');
        return back();
    }

    public function render()
    {
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
            ->latest()
            ->paginate(10);


        return view('livewire.employees.list-employee', compact('employees'));
    }
}
