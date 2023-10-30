<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Livewire\Component;

class ShowAttendance extends Component
{
    public $attendances;

    public function mount($date)
    {
        $this->attendances = Attendance::with('employee')->where('date', $date)->get();
    }

    public function render()
    {
        return view('livewire.attendance.show-attendance');
    }
}
