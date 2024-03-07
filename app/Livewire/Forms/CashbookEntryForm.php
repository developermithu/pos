<?php

namespace App\Livewire\Forms;

use App\Models\CashbookEntry;
use App\Models\Store;
use Illuminate\Validation\Rule;
use Livewire\Form;

class CashbookEntryForm extends Form
{
    public ?CashbookEntry $entry;

    public int|string $store_id = '';
    public int $account_id = 1;
    public $amount;
    public $type = '';
    public ?string $details = '';
    public $date;

    public function setCashbookEntry(CashbookEntry $entry)
    {
        $this->entry = $entry;

        $this->store_id = $entry->store_id;
        $this->amount = $entry->amount;
        $this->type = $entry->type;
        $this->details = $entry->details;
        $this->date = $entry->date->format('Y-m-d');
    }

    public function store()
    {
        $this->validate();
        CashbookEntry::create($this->only(['store_id', 'account_id', 'amount', 'type', 'details', 'date']));

        $this->reset();
    }

    public function update()
    {
        $this->validate();
        $this->entry->update($this->only(['store_id', 'amount', 'type', 'details', 'date']));
    }

    public function rules(): array
    {
        return [
            'store_id' => [
                'required',
                Rule::exists(Store::class, 'id'),
            ],
            'type' => 'required',
            'amount' => 'required|integer|numeric',
            'date' => 'required',
            'details' => 'nullable',
        ];
    }
}
