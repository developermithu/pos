<?php

namespace App\Livewire\Purchases;

use App\Enums\PaymentPaidBy;
use App\Enums\PaymentType;
use App\Enums\PurchasePaymentStatus;
use App\Enums\PurchaseStatus;
use App\Models\Account;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class CreatePurchase extends Component
{
    use Toast;

    // Purchase properties
    public int|string $supplier_id = '';
    public int|string $account_id = '';
    public string $status;
    public string $payment_status;
    public string $paid_by;
    public ?int $paid_amount = 0;
    public ?string $note = null;

    public Supplier $supplier;
    public $invoice_no;

    public string $search = '';

    public function mount()
    {
        $this->authorize('create', Purchase::class);

        $this->status = PurchaseStatus::RECEIVED->value;
        $this->payment_status = PurchasePaymentStatus::UNPAID->value;
        $this->paid_by = PaymentPaidBy::CASH->value;
    }

    public function render()
    {
        $this->authorize('create', Purchase::class);

        $search = $this->search ? '%' . trim($this->search) . '%' : null;
        $searchableFields = ['name', 'sku'];

        $products = Product::query()
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->latest('id')
            ->take(8)
            ->get();

        $accounts = Account::active()->pluck('name', 'id');

        return view('livewire.purchases.create-purchase', compact('products', 'accounts'));
    }

    public function addToCart(Product $product)
    {
        Cart::instance('purchases')->add(
            $product->id,
            $product->name,
            1,
            $product->price,
        )->associate(Product::class);

        $this->search = '';

        return back();
    }

    public function increaseQty($rowId)
    {
        $item = Cart::instance('purchases')->get($rowId);
        Cart::instance('purchases')->update($rowId, $item->qty + 1);

        $this->success(__('Quantity increased.'));

        return back();
    }

    public function decreaseQty($rowId)
    {
        $item = Cart::instance('purchases')->get($rowId);

        if ($item->qty === 1) {
            Cart::instance('purchases')->remove($rowId);
            $this->success(__('Item removed.'));
        } else {
            Cart::instance('purchases')->update($rowId, $item->qty - 1);
            $this->success(__('Quantity decreased.'));
        }

        return back();
    }

    public function removeFromCart($rowId)
    {
        Cart::instance('purchases')->remove($rowId);

        $this->success(__('Item removed.'));

        return back();
    }

    public function updatedPaymentStatus($value)
    {
        if ($value === PurchasePaymentStatus::PAID->value) {
            $this->paid_amount = $this->cartTotal();
        } else {
            $this->paid_amount = 0;
        }
    }

    public function updatedSupplierId(Supplier $supplier)
    {
        $this->supplier = $supplier;
    }

    public function createPurchase()
    {
        $this->validate();

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Insert purchase
            $purchase = $this->supplier->purchases()->create([
                'invoice_no' => rand(111111, 999999),
                'subtotal' => $this->cartSubtotal(),
                'tax' => $this->cartTax(),
                'total' => $this->cartTotal(),
                'paid_amount' => $this->paid_amount,
                'status' => $this->status,
                'payment_status' => $this->payment_status,
                'note' => $this->note,
                'date' => now(),
            ]);

            // Insert purchase Items
            foreach (Cart::instance('purchases')->content() as $item) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item->id,
                    'price' => $item->price,
                    'qty' => $item->qty,
                ]);
            }

            // Insert Payment
            if ($this->payment_status === PurchasePaymentStatus::PARTIAL->value || $this->payment_status === PurchasePaymentStatus::PAID->value) {
                $purchase->payments()->create([
                    'account_id' => $this->account_id,
                    'amount' => $this->paid_amount,
                    'reference' => 'Purchase-' . date('Ymd') . '-' . rand(00000, 99999),
                    'type' => PaymentType::DEBIT->value,
                    'paid_by' => $this->paid_by,
                    'note' => $this->note,
                ]);

                // Increase supplier expense
                if ($this->paid_by === PaymentPaidBy::DEPOSIT->value) {
                    $this->supplier->increment('expense', $this->paid_amount);
                }
            }

            // Commit the transaction
            DB::commit();

            // Clear the cart & session data
            Cart::instance('purchases')->destroy();
            $this->invoice_no = $purchase->invoice_no;

            $this->success(__('Purchases created successfully'));
            return $this->redirectRoute('admin.purchases.generate.invoice', ['invoice_no' => $this->invoice_no], navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->error(__('Something went wrong!'));
        }
    }

    public function rules(): array
    {
        $rules = [
            'supplier_id' => ['required', Rule::exists(Supplier::class, 'id')],
            'status' => ['required', Rule::in(['ordered', 'pending', 'received'])],
            'payment_status' => ['required', Rule::in(['partial', 'paid', 'unpaid'])],
            'note' => 'nullable',
        ];

        if (in_array($this->payment_status, ['partial', 'paid'])) {
            $rules['paid_by'] = ['required'];
            $rules['account_id'] = ['required', Rule::exists(Account::class, 'id')];
            $rules['paid_amount'] = [
                'required', 'int', 'gt:1', 'lte:' . $this->cartTotal(),
                function ($attribute, $value, $fail) {
                    if ($this->paid_by === PaymentPaidBy::DEPOSIT->value) {
                        $supplierDepositBalance = $this->supplier->depositBalance();
                        if ($supplierDepositBalance < $value) {
                            $fail('Ops! supplier\'s deposit balance is insufficient. Available balance ' . $supplierDepositBalance);
                        }
                    }
                },
            ];
        }

        return $rules;
    }

    //======== Format cart total, subtotal and tax amount into int ======//
    private function cartTotal()
    {
        $format = config('cart.format');

        // Extract the format settings
        $decimals = $format['decimals'];
        $decimalPoint = $format['decimal_point'];
        $thousandsSeparator = $format['thousand_seperator'];

        // Remove thousands separators and replace the decimal point if needed
        $total = str_replace($thousandsSeparator, '', Cart::instance('purchases')->total());

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
        $subtotal = str_replace($thousandsSeparator, '', Cart::instance('purchases')->subtotal());

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
        $tax = str_replace($thousandsSeparator, '', Cart::instance('purchases')->tax());

        // Convert the tax to a float
        $cartTax = (int) str_replace($decimalPoint, '.', $tax);

        return $cartTax;
    }
}
