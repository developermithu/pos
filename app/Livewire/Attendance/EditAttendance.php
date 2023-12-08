<?php

namespace App\Livewire\Attendance;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

#[Title('Edit Attendance')]
class EditAttendance extends Component
{
    use Toast;

    public $date;
    public $employees;
    public $attendanceStatus = [];

    public function mount($date)
    {
        $this->authorize('update', Attendance::class);

        $this->date = $date;
        $this->employees = Employee::all(['id', 'name']);

        $attendance = Attendance::where('date', $this->date)->get();
        $this->attendanceStatus = $attendance->pluck('status', 'employee_id')->toArray();
    }

    public function updateAttendance()
    {
        $this->validate();

        foreach ($this->attendanceStatus as $employeeId => $status) {
            Attendance::updateOrCreate([
                'employee_id' => $employeeId,
                'date' => $this->date
            ], [
                'status' => $status
            ]);
        }

        $this->success(__('Attendance updated successfully'));
        return back();
    }

    public function render()
    {
        return view('livewire.attendance.edit-attendance')->title(__('update attendance'));
    }

    public function rules()
    {
        return [
            'date' => 'required|date',
            'attendanceStatus' => 'required|array',
            'attendanceStatus.*' => [
                'required',
                // Rule::in([AttendanceStatus::PRESENT, AttendanceStatus::ABSENT, AttendanceStatus::LEAVE])
            ],
        ];
    }
}
