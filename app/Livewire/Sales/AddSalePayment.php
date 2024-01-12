<?php

namespace App\Livewire\Sales;

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

    public function mount(Sale $sale)
    {
        $this->authorize('update', $sale);

        $dueAmount = $sale->total - $sale->paid_amount;

        if ($dueAmount <= 0) {
            abort(403);
        }

        $this->sale = $sale;
        $this->received_amount = $dueAmount;
        $this->paid_amount     = $dueAmount;
    }

    public function addPayment()
    {
        $this->authorize('create', Payment::class);

        $this->validate();

        try {
            DB::beginTransaction();

            // Create Payment
            $payment = Payment::create([
                'account_id' => $this->account_id,
                'amount' => $this->paid_amount,
                'reference' => 'Sale-' . date('Ymd') . '-' . rand(11111, 99999),
                'note' => $this->note,
                'type' => PaymentType::CREDIT->value,
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

            $this->success(__('Record has been created successfully'));
            $this->reset();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error adding sale payment: ' . $e->getMessage());

            $this->error(__('Something went wrong!'));
            return back();
        }

        return back();
    }

    public function rules(): array
    {
        return [
            'paid_amount' => ['required', 'gt:0', 'lte: ' . $this->received_amount],
            'account_id'  => ['required', Rule::exists(Account::class, 'id')],
            'note'        => ['nullable', 'max:255'],
        ];
    }

    public function render()
    {
        $accounts = Account::active()->pluck('name', 'id');

        return view('livewire.sales.add-sale-payment', compact('accounts'))
            ->title(__('add payment to sell order'));
    }
}
