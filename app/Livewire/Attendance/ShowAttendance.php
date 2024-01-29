<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Carbon\Carbon;
use Livewire\Component;

class ShowAttendance extends Component
{
    public $attendances;
    public $date;

    public function mount($date)
    {
        $this->authorize('view', Attendance::class);

        $this->date = Carbon::parse($date)->format('d M, Y');
        $this->attendances = Attendance::with('employee')->where('date', $date)->get();
    }

    public function render()
    {
        return view('livewire.attendance.show-attendance')->title(__('show attendance').' | '.$this->date);
    }
}
