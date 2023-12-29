<?php

namespace App\Livewire\Forms;

use App\Models\Account;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AccountForm extends Form
{
    public ?Account $account;

    public string $name = '';
    public string $account_no = '';
    public int $initial_balance = 0;
    public ?string $details = '';
    public int $total_balance;

    public function setAccount(Account $account)
    {
        $this->account = $account;

        $this->name = $account->name;
        $this->account_no = $account->account_no;
        $this->initial_balance = $account->initial_balance;
        $this->total_balance = $account->total_balance;
        $this->details = $account->details ?? null;
    }

    public function store()
    {
        $this->validate();
        Account::create($this->only(['name', 'account_no', 'initial_balance', 'details']));

        $this->reset();
    }

    public function update()
    {
        $this->validate();
        $this->account->update([
            'name' => $this->name,
            'account_no' => $this->account_no,
            'initial_balance' => $this->initial_balance,
            'total_balance' => $this->initial_balance ?? $this->total_balance,
            'details' => $this->details,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'initial_balance' => ['required', 'numeric'],
            'account_no' => [
                'required',
                Rule::unique(Account::class)->ignore($this->account ?? null),
            ],

            'details' => 'nullable|max:255',
        ];
    }
}
