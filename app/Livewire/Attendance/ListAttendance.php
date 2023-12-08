<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListAttendance extends Component
{
    use WithPagination, Toast;

    public function destroy(Attendance $attendance)
    {
        $this->authorize('delete', $attendance);
        $attendance->delete();

        $this->success(__('Record has been deleted successfully'));
        return back();
    }

    public function render()
    {
        $this->authorize('viewAny', Attendance::class);

        $attendances = Attendance::select('date')
            ->groupBy('date')
            ->latest('date')
            ->paginate(10);

        return view('livewire.attendance.list-attendance', compact('attendances'))->title(__('attendance list'));
    }
}
