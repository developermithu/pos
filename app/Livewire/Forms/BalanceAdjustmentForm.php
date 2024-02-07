<?php

namespace App\Livewire\Forms;

use App\Enums\BalanceAdjustmentType;
use App\Enums\PaymentType;
use App\Models\Account;
use App\Models\BalanceAdjustment;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Livewire\Form;
use Mary\Traits\Toast;

class BalanceAdjustmentForm extends Form
{
    use Toast;

    public ?BalanceAdjustment $balanceAdjustment;

    public ?int $account_id = null;
    public int $amount;
    public BalanceAdjustmentType $type = BalanceAdjustmentType::AddBalance;
    public string $date;
    public ?string $details = null;

    public function setBalanceAdjustment(BalanceAdjustment $balanceAdjustment)
    {
        $this->balanceAdjustment = $balanceAdjustment;

        $this->account_id = $balanceAdjustment->payment?->account?->id;
        $this->amount = $balanceAdjustment->amount;
        $this->type = $balanceAdjustment->type;
        $this->date = $balanceAdjustment->date->format('Y-m-d');
        $this->details = $balanceAdjustment->payment?->note;
    }

    public function store()
    {
        $balanceAdjustment = BalanceAdjustment::create([
            'amount' => $this->amount,
            'type' => $this->type,
            'date' => $this->date,
        ]);

        $balanceAdded = $this->type === BalanceAdjustmentType::AddBalance;

        // Associate payment
        $balanceAdjustment->payment()->create([
            'account_id' => $this->account_id,
            'amount' => $this->amount,
            'reference' => Str::random(),
            'note' => $this->details,
            'type' => $balanceAdded ? PaymentType::CREDIT : PaymentType::DEBIT,
        ]);
    }

    public function update()
    {
        $this->balanceAdjustment->update([
            'amount' => $this->amount,
            'type' => $this->type,
            'date' => $this->date,
        ]);

        $balanceAdded = $this->type === BalanceAdjustmentType::AddBalance;

        // Associate payment
        $this->balanceAdjustment->payment()->update([
            'account_id' => $this->account_id,
            'amount' => $this->amount,
            'note' => $this->details,
            'type' => $balanceAdded ? PaymentType::CREDIT : PaymentType::DEBIT,
        ]);
    }

    public static function rules(): array
    {
        return [
            'form.account_id' => ['required', Rule::exists(Account::class, 'id')],
            'form.amount' => ['required', 'numeric', 'integer'],
            'form.type' => ['required', new Enum(BalanceAdjustmentType::class)],
            'form.date' => ['required', 'date'],
            'form.details' => ['nullable', 'max:255'],
        ];
    }

    public static function attributes(): array
    {
        return [
            'form.account_id' => 'account',
            'form.amount' => 'amount',
            'form.type' => 'type',
            'form.date' => 'date',
            'form.details' => 'details',
        ];
    }
}
