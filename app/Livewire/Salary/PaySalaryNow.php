<?php

namespace App\Livewire\Salary;

use App\Models\Employee;
use App\Models\PaySalary;
use Livewire\Component;
use Mary\Traits\Toast;

class PaySalaryNow extends Component
{
    use Toast;

    public $employee;

    public function mount($id)
    {
        $this->authorize('create', PaySalary::class);

        $this->employee = Employee::with(['advanceSalary', 'paySalary'])->findOrFail($id);
    }

    public function paidSalary()
    {
        if ($this->employee->advanceSalary) {
            $due = $this->employee->salary - $this->employee->advanceSalary->amount;
        } else {
            $due = $this->employee->salary;
        }

        $alreadyPaid = PaySalary::where('employee_id', $this->employee->id)->where('month', date('F'))->first();

        if ($alreadyPaid) {
            $this->success(__('Oops! Salary already paid.'));
            return back();
        } else {
            PaySalary::create([
                'employee_id' => $this->employee->id,
                'month' => date('F', strtotime('-1 month')),
                'amount' => $this->employee->salary,
                'advance_paid' => $this->employee->advanceSalary ? $this->employee->advanceSalary->amount : null,
                'due' => $due,
            ]);

            $this->success(__('Salary paid successfully.'));
            return back();
        }
    }

    public function render()
    {
        return view('livewire.salary.pay-salary-now')->title(__('pay salary'));
    }
}
