<?php

namespace App\Livewire\Employees;

use App\Livewire\Forms\EmployeeForm;
use App\Models\Employee;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateEmployee extends Component
{
    use Toast;

    public EmployeeForm $form;

    public function mount()
    {
        $this->authorize('create', Employee::class);
    }

    public function save()
    {
        $this->form->store();

        $this->success(__('Record has been created successfully'));

        return $this->redirect(ListEmployee::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.employees.create-employee')->title(__('add new employee'));
    }
}
