<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Livewire\Component;
use Livewire\WithPagination;

class ListAttendance extends Component
{
    use WithPagination;

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        session()->flash('status', 'Record deleted successfully.');
        return back();
    }

    public function render()
    {
        $attendances = Attendance::select('date')
            ->groupBy('date')
            ->latest('date')
            ->paginate(10);

        return view('livewire.attendance.list-attendance', compact('attendances'))->title(__('attendance list'));
    }
}
