<?php

namespace App\Livewire\Customers;

use App\Enums\PaymentType;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class AddDeposit extends Component
{
    use Toast;
    public Customer $customer;

    public int|string $account_id = '';
    public ?int $amount;
    public ?string $note = null;

    public function mount(Customer $customer)
    {
        $this->authorize('update', $customer);
        $this->customer = $customer;
    }

    public function addDeposit()
    {
        $this->authorize('create', Customer::class);
        $this->validate();

        try {
            DB::beginTransaction();

            // Create Payment
            $payment = Payment::create([
                'account_id' => $this->account_id,
                'amount' => $this->amount,
                'reference' => 'Deposit-' . date('Ymd') . '-' . rand(11111, 99999),
                'note' => $this->note,
                'type' => PaymentType::CREDIT->value,
                'paymentable_id' => $this->customer->id,
                'paymentable_type' => Customer::class
            ]);

            // Update customer deposit amount
            $this->customer->deposit += $payment->amount;
            $this->customer->save();

            DB::commit();

            $this->success(__('Record has been created successfully'));
            $this->reset();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            $this->error(__('Something went wrong!'));
            return back();
        }

        return back();
    }

    public function render()
    {
        $accounts = Account::active()->pluck('name', 'id');
        return view('livewire.customers.add-deposit', compact('accounts'))
            ->title(__('add deposit'));
    }

    public function rules(): array
    {
        return [
            'amount'      => ['required', 'integer', 'gt:0'],
            'account_id'  => ['required', Rule::exists(Account::class, 'id')],
            'note'        => ['nullable', 'max:255'],
        ];
    }
}
