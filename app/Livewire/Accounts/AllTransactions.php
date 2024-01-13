<?php

namespace App\Livewire\Accounts;

use App\Models\Payment;
use App\Traits\SearchAndFilter;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AllTransactions extends Component
{
    use WithPagination, SearchAndFilter;

    public $type = [];

    #[Url('start_date')]
    public $start_date;

    #[Url('end_date')]
    public $end_date;

    public function render()
    {
        $this->authorize('viewAny', Payment::class);

        $search = $this->search ? '%' . trim($this->search) . '%' : null;
        $searchableFields = ['reference', 'type', 'note'];

        $transactions = Payment::query()
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->when($this->type, function ($query) {
                $query->whereIn('type', $this->type);
            })
            ->when($this->start_date && $this->end_date, function ($query) {
                $query->whereBetween('created_at', [$this->start_date, $this->end_date]);
            })
            ->with('account')
            ->latest()
            ->paginate(25);

        return view('livewire.accounts.all-transactions', compact('transactions'))
            ->title(__('all transactions'));
    }

    public function clear()
    {
        $this->type = [];
        $this->search = '';
        $this->start_date = '';
        $this->end_date = '';
    }
}
