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
use App\Models\Unit;
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
    public ?string $details = null;

    public Supplier $supplier;
    public $invoice_no;

    public string $search = '';

    // Edit product
    public Product $product;
    public bool $productEditModal = false;
    public int $cost;
    public $type;
    public int $purchase_unit_id;
    public $purchase_units = [];

    public $rowId;

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

        $search = $this->search ? '%'.trim($this->search).'%' : null;
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
        // Check if the product is already in the cart
        $existingItem = Cart::instance('purchases')->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        })->first();

        if ($existingItem) {
            $this->info(__('Product is already added in the cart.'));
        } else {
            Cart::instance('purchases')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->cost,
                'options' => [
                    'purchase_unit_id' => $product->purchase_unit_id ?? $product->unit_id,
                ],
            ])->associate(Product::class);
        }

        $this->search = '';
    }

    public function removeFromCart($rowId)
    {
        Cart::instance('purchases')->remove($rowId);

        $this->success(__('Item removed.'));

        return back();
    }

    public function updateQty(string $rowId, int|float $purchaseQty)
    {
        if ($purchaseQty > 0) {
            Cart::instance('purchases')->update($rowId, $purchaseQty);
            $this->success(__('Quantity updated successfully.'));
        } else {
            $this->redirect(CreatePurchase::class, navigate: true);
            $this->error(__('Quantity must be greater than 0.'));
        }
    }

    public function updatePrice(string $rowId, int $purchasePrice)
    {
        if ($purchasePrice > 0) {
            Cart::instance('purchases')->update($rowId, [
                'price' => $purchasePrice,
            ]);

            $this->success(__('Price updated.'));
        } else {
            $this->redirect(CreatePurchase::class, navigate: true);
            $this->error(__('Price must be greater than 0.'));
        }
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

    public function showProductEditModal(string $rowId, Product $product)
    {
        $this->reset(['purchase_unit_id', 'cost']);
        $this->productEditModal = true;
        $this->product = $product;

        $this->type = $product->type;
        $this->purchase_unit_id = $product->purchase_unit_id ?? $product->unit_id;
        $this->cost = $product->cost;
        $this->purchase_units = Unit::whereId($product->unit_id)
            ->orWhere('unit_id', $product->unit_id)
            ->pluck('name', 'id');

        $this->rowId = $rowId;
    }

    public function editProduct()
    {
        $this->validate([
            'purchase_unit_id' => ['required', Rule::exists(Unit::class, 'id')],
        ]);

        DB::beginTransaction();

        try {
            Cart::instance('purchases')->update($this->rowId, [
                'options' => [
                    'purchase_unit_id' => $this->purchase_unit_id,
                ],
            ]);

            $this->product->update(['purchase_unit_id' => $this->purchase_unit_id]);

            DB::commit();
            $this->productEditModal = false;
            $this->success(__('Product purchase unit has been updated.'));
        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
        }
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
                'details' => $this->details,
                'date' => now(),
            ]);

            // Insert purchase Items
            foreach (Cart::instance('purchases')->content() as $item) {
                // increment product quantity based on purchase unit
                $purchaseUnit = Unit::findOrFail($item->options['purchase_unit_id']);
                $convertedQty = $purchaseUnit->convertQuantity($item->qty, $purchaseUnit->operator, $purchaseUnit->operation_value);

                if ($convertedQty !== null && $convertedQty > 0) {
                    // increase product quantity
                    if ($this->status === PurchaseStatus::RECEIVED->value) {
                        $item->model->increment('qty', $convertedQty * 100); // for mutator
                    }
                } else {
                    Log::error('Invalid purchase qty convertion.');
                }

                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item->id,
                    'cost' => $item->price,
                    'qty' => $item->qty,
                    'purchase_unit_id' => $item->options['purchase_unit_id'],
                ]);
            }

            // Insert Payment
            if ($this->payment_status === PurchasePaymentStatus::PARTIAL->value || $this->payment_status === PurchasePaymentStatus::PAID->value) {
                $purchase->payments()->create([
                    'account_id' => $this->account_id,
                    'amount' => $this->paid_amount,
                    'reference' => 'Purchase',
                    'type' => PaymentType::DEBIT->value,
                    'paid_by' => $this->paid_by,
                    'details' => $this->details,
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
            'details' => 'nullable',
        ];

        if (in_array($this->payment_status, ['partial', 'paid'])) {
            $rules['paid_by'] = ['required'];
            $rules['account_id'] = ['required', Rule::exists(Account::class, 'id')];
            $rules['paid_amount'] = [
                'required', 'int', 'gt:1', 'lte:'.$this->cartTotal(),
                function ($attribute, $value, $fail) {
                    if ($this->paid_by === PaymentPaidBy::DEPOSIT->value && isset($this->supplier)) {
                        $supplierDepositBalance = $this->supplier->depositBalance();
                        if ($supplierDepositBalance < $value) {
                            $fail('Ops! supplier\'s deposit balance is insufficient. Available balance '.$supplierDepositBalance);
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
