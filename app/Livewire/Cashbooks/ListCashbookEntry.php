<?php

namespace App\Livewire\Cashbooks;

use App\Livewire\Forms\CashbookEntryForm;
use App\Models\CashbookEntry;
use App\Traits\SearchAndFilter;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListCashbookEntry extends Component
{
    use WithPagination, Toast, SearchAndFilter;

    public CashbookEntryForm $form;

    public $selected = [];

    public function create()
    {
        $this->authorize('create', CashbookEntry::class);
        $this->form->store();

        $this->success(__('Record has been created successfully'));
        $this->dispatch('close');
    }

    public function deleteSelected()
    {
        $this->authorize('bulkDelete', CashbookEntry::class);

        if ($this->selected) {
            CashbookEntry::destroy($this->selected);

            $this->success(__('Selected records has been deleted'));
        } else {
            $this->success(__('You did not select anything'));
        }

        return back();
    }

    public function destroy(CashbookEntry $entry)
    {
        $this->authorize('delete', $entry);
        $entry->delete();

        $this->success(__('Record has been deleted successfully'));
        return back();
    }

    public function forceDelete($id)
    {
        $entry = CashbookEntry::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $entry);
        $entry->forceDelete();

        $this->success(__('Record has been deleted permanently'));
        return back();
    }

    public function restore($id)
    {
        $entry = CashbookEntry::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $entry);
        $entry->restore();

        $this->success(__('Record has been restored successfully'));
        return back();
    }

    public function render()
    {
        $this->authorize('viewAny', CashbookEntry::class);

        $search = $this->search ? '%' . trim($this->search) . '%' : null;
        $searchableFields = ['type', 'note'];

        $cashbookEntries = CashbookEntry::query()
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->when($this->filterByTrash, function ($query, $value) {
                if ($value === "onlyTrashed") {
                    $query->onlyTrashed();
                } elseif ($value === "withTrashed") {
                    $query->withTrashed();
                }
            })
            ->latest()
            ->paginate(10);


        $today = Carbon::now()->toDateString();
        $currentMonth = Carbon::now()->startOfMonth()->toDateString();
        $currentYear = Carbon::now()->startOfYear()->toDateString();

        $totalTodaysDeposits = $this->calculateTotalAmount('deposit', $today);
        $totalTodaysExpenses = $this->calculateTotalAmount('expense', $today);

        $totalMonthlyDeposits = $this->calculateTotalAmount('deposit', $currentMonth);
        $totalMonthlyExpenses = $this->calculateTotalAmount('expense', $currentMonth);

        $totalYearlyDeposits = $this->calculateTotalAmount('deposit', $currentYear);
        $totalYearlyExpenses = $this->calculateTotalAmount('expense', $currentYear);

        return view(
            'livewire.cashbooks.list-cashbook-entry',
            compact([
                'cashbookEntries',
                'totalTodaysDeposits',
                'totalTodaysExpenses',
                'totalMonthlyDeposits',
                'totalMonthlyExpenses',
                'totalYearlyDeposits',
                'totalYearlyExpenses',
            ])
        )

            ->title(__('cashbook entry list'));
    }

    public function calculateTotalAmount($type, $startDate)
    {
        $rawAmounts = CashbookEntry::where('type', $type)
            ->whereDate('date', '>=', $startDate)
            ->whereNull('deleted_at')
            ->pluck('amount');

        // Applying the mutator manually
        $totalAmount = $rawAmounts->sum() / 100;

        return $totalAmount;
    }
}
