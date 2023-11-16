<?php

namespace App\Livewire\Pos;

use App\Enums\SaleStatus;
use App\Enums\TransactionStatus;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Transaction;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateInvoice extends Component
{
    public $payment_method = "";
    public int $paid_amount;
    public $due;
    public $cartTotal;

    public $transaction_id;
    public $bank_details;

    public function mount()
    {
        $this->due = $this->cartTotal();
        $this->cartTotal = $this->cartTotal();
    }

    public function render()
    {
        return view('livewire.pos.create-invoice')->title(__('create invoice'));
    }

    public function generateInvoice()
    {
        $this->validate();

        // insert sale
        $sale = Sale::create([
            'customer_id' => session()->get('customer')['id'],
            'invoice_no' => session()->get('invoice_no'),
            'subtotal' => $this->cartSubtotal(),
            'tax' => $this->cartTax(),
            'total' => $this->cartTotal(),

            'payment_method' => $this->payment_method,
            'status' => ($this->paid_amount == $this->cartTotal) ? SaleStatus::COMPLETED : SaleStatus::PENDING,
            'date' => date('Y-m-d'),
        ]);

        if ($sale) {
            // insert transaction
            $transaction = Transaction::create([
                'sale_id' => $sale->id,
                'method' => $this->payment_method,
                'transaction_id' => $this->transaction_id ?? null,
                'details' => $this->bank_details ?? null,
                'status' => ($this->paid_amount == $this->cartTotal) ? TransactionStatus::COMPLETED : TransactionStatus::PENDING,
            ]);

            // insert sale items
            if ($transaction) {
                foreach (Cart::content() as $item) {
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $item->id,
                        'price' => $item->price,
                        'qty' => $item->qty,
                    ]);
                }
            }
        }

        // Clear the cart & session data
        Cart::destroy();
        session()->forget('customer');
        session()->forget('invoice_no');

        // Sending invoice email
        session()->flash('status', 'Sales generated successfully');
        return $this->redirect(PosManagement::class, navigate: true);
    }

    public function updatedPaidAmount($value)
    {
        $this->due = $value ? $this->cartTotal() - (int) $this->paid_amount : $this->cartTotal;
    }

    public function rules(): array
    {
        return [
            'payment_method' => ['required', Rule::in(['cashe', 'bkash', 'bank'])],
            'paid_amount' => 'required|integer|lte:' . $this->cartTotal, //paid_amount is (less than or equal) to cartTotal.
            'transaction_id' => [
                Rule::requiredIf(function () {
                    return $this->payment_method === 'bkash';
                }),
            ],
            'bank_details' => [
                Rule::requiredIf(function () {
                    return $this->payment_method === 'bank';
                }),
            ],
        ];
    }

    // format cart total, subtotal and tax amount into integer
    private function cartTotal()
    {
        $format = config('cart.format');

        // Extract the format settings
        $decimals = $format['decimals'];
        $decimalPoint = $format['decimal_point'];
        $thousandsSeparator = $format['thousand_seperator'];

        // Remove thousands separators and replace the decimal point if needed
        $total = str_replace($thousandsSeparator, '', Cart::total());

        // Convert the total to a float
        $cartTotal = (int) str_replace($decimalPoint, '.', $total);

        return $cartTotal;
    }

    private function cartSubtotal()
    {
        $format = config('cart.format');

        // Extract the format settings
        $decimals = $format['decimals'];
        $decimalPoint = $format['decimal_point'];
        $thousandsSeparator = $format['thousand_seperator'];

        // Remove thousands separators and replace the decimal point if needed
        $subtotal = str_replace($thousandsSeparator, '', Cart::subtotal());

        // Convert the total to a float
        $cartSubtotal = (int) str_replace($decimalPoint, '.', $subtotal);

        return $cartSubtotal;
    }

    private function cartTax()
    {
        $format = config('cart.format');

        // Extract the format settings
        $decimals = $format['decimals'];
        $decimalPoint = $format['decimal_point'];
        $thousandsSeparator = $format['thousand_seperator'];

        // Remove thousands separators and replace the decimal point if needed
        $tax = str_replace($thousandsSeparator, '', Cart::tax());

        // Convert the tax to a float
        $cartTax = (int) str_replace($decimalPoint, '.', $tax);

        return $cartTax;
    }
}
