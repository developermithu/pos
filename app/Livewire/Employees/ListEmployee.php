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
    public $search = "";
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
        $employees = Employee::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('father_name', 'like', '%' . $this->search . '%')
            ->orWhere('address', 'like', '%' . $this->search . '%')
            ->orWhere('phone_number', 'like', '%' . $this->search . '%')
            ->orWhere('salary', 'like', '%' . $this->search . '%')
            ->orWhere('gender', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.employees.list-employee', compact('employees'));
    }
}
