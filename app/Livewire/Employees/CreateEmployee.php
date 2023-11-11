<?php

namespace App\Livewire\Employees;

use App\Livewire\Forms\EmployeeForm;
use Livewire\Component;

class CreateEmployee extends Component
{
    public EmployeeForm $form;

    public function save()
    {
        $this->form->store();

        session()->flash('status', 'Record created successfully.');
        return $this->redirect(ListEmployee::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.employees.create-employee')->title(__('add new employee'));
    }
}
