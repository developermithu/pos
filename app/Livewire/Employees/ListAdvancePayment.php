<?php

namespace App\Livewire\Employees;

use App\Models\Employee;
use App\Models\Payment;
use App\Traits\SearchAndFilter;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListAdvancePayment extends Component
{
    use SearchAndFilter, WithPagination;

    #[Url('date')]
    public $selectedTimePeriod = '';

    public function render()
    {
        $advancePayments = Payment::query()
            ->wherePaymentableType(Employee::class)
            ->when($this->selectedTimePeriod, function ($query, $value) {
                if ($value === 'todays') {
                    $query->whereDate('created_at', now()->today());
                } elseif ($value === 'current-month') {
                    $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                } elseif ($value === 'last-month') {
                    $query->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
                }
            })
            ->when($this->search, function ($query, $search) {
                $query->whereHas('employee', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%'.$search.'%');
                })->orWhere('note', 'like', '%'.$search.'%');
            })
            ->latest()
            ->with('employee:id,name')
            ->paginate(10);

        return view('livewire.employees.list-advance-payment', compact('advancePayments'));
    }

    public function filterByTimePeriod(?string $timePeriod)
    {
        $this->selectedTimePeriod = $timePeriod;
    }
}
