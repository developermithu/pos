<?php

namespace App\Livewire\Forms;

use App\Models\Employee;
use App\Models\Overtime;
use Illuminate\Validation\Rule;
use Livewire\Form;

class OvertimeForm extends Form
{
    public ?Overtime $overtime;

    public int|string $employee_id = '';
    public $hours_worked;
    public $rate_per_hour;
    public $total_amount;
    public $date;

    public function setOvertime(Overtime $overtime)
    {
        $this->overtime = $overtime;

        $this->employee_id = $overtime->employee_id;
        $this->hours_worked = $overtime->hours_worked;
        $this->rate_per_hour = $overtime->rate_per_hour;
        $this->total_amount = $overtime->total_amount;
        $this->date = $overtime->date->format('Y-m-d');
    }

    public function store()
    {
        $validatedData = $this->validate();

        $totalAmount = $validatedData['hours_worked'] * $validatedData['rate_per_hour'];

        // Ensure total amount is rounded to the nearest integer
        $validatedData['total_amount'] = (int) round($totalAmount);

        Overtime::create($validatedData);
    }

    public function update()
    {
        $validatedData = $this->validate();

        $totalAmount = $validatedData['hours_worked'] * $validatedData['rate_per_hour'];

        // Ensure total amount is rounded to the nearest integer
        $validatedData['total_amount'] = (int) round($totalAmount);

        $this->overtime->update($validatedData);
    }

    protected function rules(): array
    {
        return [
            'employee_id' => ['required', Rule::exists(Employee::class, 'id')],
            'hours_worked' => 'required|numeric|min:1',
            'rate_per_hour' => 'required|numeric|min:10',
            'date' => 'required|date',
        ];
    }
}
