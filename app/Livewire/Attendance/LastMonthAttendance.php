<?php

namespace App\Livewire\Attendance;

use App\Models\Employee;
use Livewire\Component;

class LastMonthAttendance extends Component
{
    public function render()
    {
        $employees = Employee::with('attendances')->select('id', 'name')->get();

        return view('livewire.attendance.last-month-attendance', compact('employees'));
    }
}
