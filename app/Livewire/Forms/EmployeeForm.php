<?php

namespace App\Livewire\Forms;

use App\Models\Employee;
use Livewire\Attributes\Rule;
use Livewire\Form;

class EmployeeForm extends Form
{
    public ?Employee $employee;

    #[Rule('required|max:255')]
    public $name;

    #[Rule('required|max:255', as: 'father name')]
    public $father_name;

    #[Rule('required|max:255')]
    public $address;

    #[Rule('required|max:255', as: 'phone number')]
    public $phone_number;

    #[Rule('required|max:255')]
    public $salary;

    #[Rule('required|date', as: 'joining date')]
    public $joined_at;

    #[Rule('required|in:male,female')]
    public $gender;

    public function setEmployee(Employee $employee)
    {
        $this->employee = $employee;

        $this->name = $employee->name;
        $this->father_name = $employee->father_name;
        $this->address = $employee->address;
        $this->phone_number = $employee->phone_number;
        $this->salary = $employee->salary;
        $this->joined_at = $employee->joined_at->format('Y-m-d');
        $this->gender = $employee->gender;
    }

    public function store()
    {
        $this->validate();

        Employee::create($this->only(['name', 'father_name', 'address', 'phone_number', 'salary', 'joined_at', 'gender']));
    }

    public function update()
    {
        $this->validate();

        $this->employee->update(
            $this->only(['name', 'father_name', 'address', 'phone_number', 'salary', 'joined_at', 'gender'])
        );
    }
}
