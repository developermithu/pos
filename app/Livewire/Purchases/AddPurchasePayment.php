<?php

namespace App\Livewire\Purchases;

use App\Enums\PaymentType;
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
    public int|string $account_id = '';
    public ?string $note = null;

    public function mount(Purchase $purchase)
    {
        $this->authorize('update', $purchase);

        $dueAmount = $purchase->total - $purchase->paid_amount;

        $this->purchase = $purchase;
        $this->received_amount = $dueAmount;
        $this->paid_amount = $dueAmount;
    }

    public function render()
    {
        $accounts = Account::active()->pluck('name', 'id');

        return view('livewire.purchases.add-purchase-payment', compact('accounts'))
            ->title(__('add payment to purchase order'));
    }

    // Add Payment
    public function addPayment()
    {
        $this->authorize('create', Payment::class);

        $this->validate();

        DB::beginTransaction();
        
        try {
            // Create Payment
            $payment = Payment::create([
                'account_id' => $this->account_id,
                'amount' => $this->paid_amount,
                'reference' => 'Purchase-'.date('Ymd').'-'.rand(11111, 99999),
                'note' => $this->note,
                'type' => PaymentType::DEBIT->value,
                'paymentable_id' => $this->purchase->id,
                'paymentable_type' => Purchase::class,
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

            return $this->redirect(ListPurchase::class, navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating purchase: '.$e->getMessage());
            $this->error(__('Something went wrong!'));

            return back();
        }
    }

    public function rules(): array
    {
        return [
            'received_amount' => ['required', 'gt:0', 'lte: '.$this->purchase->total - $this->purchase->paid_amount],
            'paid_amount' => ['required', 'gt:0', 'lte: '.$this->received_amount],
            'account_id' => ['required', Rule::exists(Account::class, 'id')],
            'note' => ['nullable', 'max:255'],
        ];
    }
}
