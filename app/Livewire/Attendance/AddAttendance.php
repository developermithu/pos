<?php

namespace App\Livewire\Attendance;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class AddAttendance extends Component
{
    use Toast;

    public $date;
    public $attendanceStatus = [];

    public function mount()
    {
        $this->authorize('create', Attendance::class);
        $this->date = now()->today()->format('Y-m-d');
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

        $this->success(__('Attendance marked successfully'));
        return $this->redirect(ListAttendance::class, navigate: true);
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
                // Rule::in([AttendanceStatus::PRESENT, AttendanceStatus::ABSENT])
            ],
        ];
    }
}
