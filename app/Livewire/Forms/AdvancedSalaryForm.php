<?php

namespace App\Livewire\Forms;

use App\Livewire\Salary\ListAdvancedSalary;
use App\Models\AdvancedSalary;
use Livewire\Attributes\Rule;
use Livewire\Form;

class AdvancedSalaryForm extends Form
{
    public ?AdvancedSalary $advanced_salary;

    #[Rule('required|exists:employees,id', as: 'employee')]
    public $employee_id = '';

    #[Rule('required')]
    public string $month = '';

    #[Rule('required')]
    public string $year = '';

    #[Rule('required|numeric')]
    public $amount;

    // automatically inserted from model boot method
    public $paid_at;

    public function setAdvancedSalary(AdvancedSalary $advanced_salary)
    {
        $this->advanced_salary = $advanced_salary;

        $this->employee_id = $advanced_salary->employee_id;
        $this->month = $advanced_salary->month;
        $this->year = $advanced_salary->year;
        $this->amount = $advanced_salary->amount;
        $this->paid_at = $advanced_salary->paid_at->format('d M, Y');
    }

    public function store()
    {
        $this->validate();

        $alreadyPaid = AdvancedSalary::where('month', $this->month)
            ->where('year', $this->year)
            ->where('employee_id', $this->employee_id)
            ->first();

        if ($alreadyPaid) {
            session()->flash('status', 'Advanced salary already paid.');
            return back();
        } else {
            AdvancedSalary::create(
                $this->only([
                    'employee_id',
                    'month',
                    'year',
                    'amount',
                ])
            );

            $this->reset();

            session()->flash('status', __('Record has been created successfully'));
            return back();
        }
    }

    public function update()
    {
        $this->validate();

        $this->advanced_salary->update(
            $this->only([
                'employee_id',
                'month',
                'year',
                'amount',
            ])
        );
    }
}
