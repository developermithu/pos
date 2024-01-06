<?php

namespace App\Livewire\Purchases;

use App\Enums\PurchasePaymentStatus;
use App\Models\Account;
use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class AddPurchasePayment extends Component
{
    use Toast;

    public Purchase $purchase;

    public ?int $received_amount;
    public ?int $paid_amount;
    public ?string $paid_by = 'cash';
    public int|string $account_id = '';
    public ?string $note = null;

    public function mount(Purchase $purchase)
    {
        $this->authorize('update', $purchase);

        $dueAmount = $purchase->total - $purchase->paid_amount;

        if ($dueAmount <= 0) {
            abort(403);
        }

        $this->purchase        = $purchase;
        $this->received_amount = $dueAmount;
        $this->paid_amount     = $dueAmount;
    }

    public function render()
    {
        return view('livewire.purchases.add-purchase-payment')
            ->title(__('add payment to purchase order'));
    }

    // Add Payment
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
                'payment_method' => $this->paid_by,
                'reference' => 'SR-' . date('Ymd') . '-' . rand(11111, 99999),
                'note' => $this->note,
                'paymentable_id' => $this->purchase->id,
                'paymentable_type' => Purchase::class
            ]);

            // Update purchase paid amount
            $this->purchase->paid_amount += $payment->amount;
            $this->purchase->save();

            if ($this->purchase->paid_amount > 0 && $this->purchase->paid_amount < $this->purchase->total) {
                $this->purchase->payment_status = PurchasePaymentStatus::PARTIAL->value;
            } elseif ($this->purchase->paid_amount == 0) {
                $this->purchase->payment_status = purchasePaymentStatus::UNPAID->value;
            } elseif ($this->purchase->paid_amount === $this->purchase->total) {
                $this->purchase->payment_status = purchasePaymentStatus::PAID->value;
            }

            // Save the changes
            $this->purchase->save();

            DB::commit();

            $this->success(__('Record has been created successfully'));
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
