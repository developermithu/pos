<?php

namespace App\Livewire\Attendance;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AddAttendance extends Component
{
    public $date;
    public $attendanceStatus = [];

    public function mount()
    {
        $this->authorize('create', Attendance::class);
    }

    public function markAttendance()
    {
        $this->validate();

        foreach ($this->attendanceStatus as $employeeId => $status) {
            Attendance::updateOrCreate([
                'employee_id' => $employeeId,
                'date' => $this->date,
            ], [
                'status' => $status,
            ]);
        }

        $this->attendanceStatus = [];
        $this->date = '';

        session()->flash('status', 'Attendance marked successfully');

        return back();
    }

    public function render()
    {
        $employees = Employee::all(['id', 'name']);
        return view('livewire.attendance.add-attendance', compact('employees'))->title(__('add attendance'));
    }

    public function rules()
    {
        return [
            'date' => 'required|date',
            'attendanceStatus' => 'required|array',
            'attendanceStatus.*' => [
                'required',
                Rule::in([AttendanceStatus::PRESENT, AttendanceStatus::ABSENT, AttendanceStatus::LEAVE])
            ],
        ];
    }
}
