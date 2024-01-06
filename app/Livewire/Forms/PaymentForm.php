<?php

namespace App\Livewire\Forms;

use App\Enums\SalePaymentStatus;
use App\Enums\SaleStatus;
use App\Models\Account;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Mary\Traits\Toast;

class PaymentForm extends Form
{
    use Toast;

    public ?Payment $payment;
    public ?Sale $sale;

    public ?int $received_amount;
    public ?int $paid_amount;
    public ?string $paid_by = 'cash';
    public int|string $account_id = '';
    public ?string $note = null;

    public function setSale(Sale $sale)
    {
        $this->sale = $sale;
    }

    public function setPayment(Payment $payment)
    {
        $this->payment = $payment;

        $this->paid_amount = $payment->paid_amount;
        $this->paid_by = $payment->paid_by;
        $this->account_id = $payment->account_id;
        $this->note = $payment->note ?? null;
    }

    public function store()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Create Payment
            $payment = Payment::create([
                'account_id' => $this->account_id,
                'amount' => $this->paid_amount,
                'payment_method' => $this->paid_by,
                'reference' => 'SR-' . date('Ymd') . '-' . rand(11111, 99999),
                'note' => $this->note,
                'paymentable_id' => $this->sale->id,
                'paymentable_type' => Sale::class
            ]);

            // Update Sale paid amount
            $this->sale->paid_amount += $payment->amount;
            $this->sale->save();

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

            $this->reset();
        } catch (\Exception $e) {
            DB::rollBack();

            $this->error(__('Something went wrong!'));
            return back();
        }
    }

    public function rules(): array
    {
        return [
            'paid_amount' => ['required', 'gt:0', 'lte: ' . $this->received_amount],
            'paid_by'     => ['required', Rule::in(['cash', 'cheque', 'bank', 'bkash'])],
            'account_id'  => ['required', Rule::exists(Account::class, 'id')],
            'note'        => ['nullable', 'max:255'],
        ];
    }
}
