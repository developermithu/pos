<?php

namespace App\Livewire\Cashbooks;

use App\Livewire\Forms\CashbookEntryForm;
use App\Models\CashbookEntry;
use Livewire\Component;
use Mary\Traits\Toast;

class EditCashbookEntry extends Component
{
    use Toast;
    public CashbookEntryForm $form;

    public function mount(CashbookEntry $cashbookEntry)
    {
        $this->authorize('update', $cashbookEntry);
        $this->form->setCashbookEntry($cashbookEntry);
    }

    public function save()
    {
        $this->form->update();

        $this->success(__('Record has been updated successfully'));

        return $this->redirect(ListCashbookEntry::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.cashbooks.edit-cashbook-entry')
            ->title(__('update cashbook entry'));
    }
}
