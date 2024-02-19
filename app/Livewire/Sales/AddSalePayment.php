<?php

namespace App\Livewire\Sales;

use App\Enums\PaymentPaidBy;
use App\Enums\PaymentType;
use App\Enums\SalePaymentStatus;
use App\Models\Account;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class AddSalePayment extends Component
{
    use Toast;

    public Sale $sale;

    public ?int $received_amount;
    public ?int $paid_amount;
    public int|string $account_id = '';
    public ?string $note = null;
    public string $paid_by;

    public function mount(Sale $sale)
    {
        $this->authorize('update', $sale);

        $dueAmount = $sale->total - $sale->paid_amount;

        $this->sale = $sale;
        $this->received_amount = $dueAmount;
        $this->paid_amount = $dueAmount;
        $this->paid_by = PaymentPaidBy::CASH->value;
    }

    public function addPayment()
    {
        $this->authorize('create', Payment::class);

        $this->validate();
        DB::beginTransaction();

        try {
            $payment = $this->sale->payments()->create([
                'account_id' => $this->account_id,
                'amount' => $this->paid_amount,
                'reference' => 'Sale-' . date('Ymd') . '-' . rand(11111, 99999),
                'note' => $this->note,
                'type' => PaymentType::CREDIT->value,
                'paid_by' => $this->paid_by,
            ]);

            // Increase customer expense
            if ($this->paid_by === PaymentPaidBy::DEPOSIT->value && $this->sale->customer->depositBalance() >= $this->paid_amount) {
                $this->sale->customer->increment('expense', $this->paid_amount);
            }

            // Update Sale paid amount
            $this->sale->paid_amount += $payment->amount;

            if ($this->sale->paid_amount > 0 && $this->sale->paid_amount < $this->sale->total) {
                $this->sale->payment_status = SalePaymentStatus::PARTIAL->value;
            } elseif ($this->sale->paid_amount == 0) {
                $this->sale->payment_status = SalePaymentStatus::DUE->value;
            } elseif ($this->sale->paid_amount === $this->sale->total) {
                $this->sale->payment_status = SalePaymentStatus::PAID->value;
            }

            // Save the changes
            $this->sale->save();

            DB::commit();
            $this->success(__('Record has been created successfully'));
            $this->redirect(ListSale::class, navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error adding sale payment: ' . $e->getMessage());
            $this->error(__('Something went wrong!'));
        }
    }

    protected function rules(): array
    {
        return [
            'received_amount' => ['required', 'gt:0', 'lte: ' . $this->sale->total - $this->sale->paid_amount],
            'paid_amount' => [
                'required', 'gt:0', 'lte: ' . $this->received_amount,
                function ($attribute, $value, $fail) {
                    if ($this->paid_by === PaymentPaidBy::DEPOSIT->value) {
                        $customerDepositBalance = $this->sale->customer->depositBalance();
                        if ($customerDepositBalance < $value) {
                            $fail('Ops! Customer\'s deposit balance is insufficient. Available balance ' . $customerDepositBalance);
                        }
                    }
                },
            ],
            'paid_by' => ['required'],
            'account_id' => ['required', Rule::exists(Account::class, 'id')],
            'note' => ['nullable', 'max:255'],
        ];
    }

    public function render()
    {
        $accounts = Account::active()->pluck('name', 'id');

        return view('livewire.sales.add-sale-payment', compact('accounts'))
            ->title(__('add payment to sell order'));
    }
}
