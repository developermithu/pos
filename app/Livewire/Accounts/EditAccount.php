<?php

namespace App\Livewire\Accounts;

use App\Livewire\Forms\AccountForm;
use App\Models\Account;
use Livewire\Component;
use Mary\Traits\Toast;

class EditAccount extends Component
{
    use Toast;

    public AccountForm $form;

    public function mount(Account $account)
    {
        $this->authorize('update', $account);
        $this->form->setAccount($account);
    }

    public function save()
    {
        $this->form->update();

        $this->success(__('Record has been updated successfully'));

        return $this->redirect(ListAccount::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.accounts.edit-account')
            ->title(__('update account'));
    }
}
