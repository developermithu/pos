<?php

namespace App\Livewire\Employees;

use App\Livewire\Forms\EmployeeForm;
use App\Models\Employee;
use Livewire\Component;
use Mary\Traits\Toast;

class EditEmployee extends Component
{
    use Toast;

    public EmployeeForm $form;

    public function mount(Employee $employee)
    {
        $this->authorize('update', $employee);

        $this->form->setEmployee($employee);
    }

    public function save()
    {
        $this->form->update();

        $this->success(__('Record has been updated successfully'));
        return $this->redirect(ListEmployee::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.employees.edit-employee')->title(__('update employee'));
    }
}
