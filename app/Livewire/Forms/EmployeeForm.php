<?php

namespace App\Livewire\Forms;

use App\Models\Employee;
use Illuminate\Validation\Rule;
use Livewire\Form;

class EmployeeForm extends Form
{
    public ?Employee $employee;

    public $name;
    public $father_name;
    public $address;
    public $phone_number;
    public $basic_salary;
    public $new_basic_salary;
    public $joined_at;
    public $gender;

    public function setEmployee(Employee $employee)
    {
        $this->employee = $employee;

        $this->name = $employee->name;
        $this->father_name = $employee->father_name;
        $this->address = $employee->address;
        $this->phone_number = $employee->phone_number;
        $this->basic_salary = $employee->basic_salary;
        $this->joined_at = $employee->joined_at->format('Y-m-d');
        $this->gender = $employee->gender;
    }

    public function store()
    {
        $this->validate();

        Employee::create($this->only(['name', 'father_name', 'address', 'phone_number', 'basic_salary', 'joined_at', 'gender']));
    }

    public function update()
    {
        $this->validate();

        $this->employee->update([
            'name' => $this->name,
            'father_name' => $this->father_name,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'joined_at' => $this->joined_at,
            'gender' => $this->gender,
        ]);

        // update salary
        if ($this->new_basic_salary) {
            $this->employee->update([
                'basic_salary' => $this->new_basic_salary, // new salary
                'old_basic_salary' => $this->basic_salary, // old salary
                'salary_updated_at' => now(),
            ]);
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'father_name' => ['required', 'max:255'],
            'address' => ['nullable', 'max:255'],
            'phone_number' => [
                'required', 'max:255',
                Rule::unique(Employee::class, 'phone_number')
                    ->ignore($this->employee ?? null)
            ],
            'basic_salary' => ['required', 'max:255'],
            'new_basic_salary' => ['nullable', 'numeric', "gt:$this->basic_salary"],
            'joined_at' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
        ];
    }
}
