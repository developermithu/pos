<?php

namespace App\Livewire\Pos;

use App\Enums\PaymentPaidBy;
use App\Enums\PaymentType;
use App\Enums\SalePaymentStatus;
use App\Enums\SaleStatus;
use App\Livewire\Forms\CustomerForm;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Unit;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

// #[Lazy]
#[Title('pos')]
class PosManagement extends Component
{
    use Toast, WithPagination;

    public CustomerForm $form;

    public $perPage = 10;

    #[Url(as: 'q')]
    public string $search = '';

    // Creating sale properties
    public int|string $customer_id = '';
    public int|string $account_id = '';
    public string $status;
    public string $payment_status;
    public string $paid_by;
    public ?int $paid_amount = 0;
    public ?string $details = null;

    public Customer $customer;
    public $invoice_no;

    // Edit product
    public Product $product;
    public bool $productEditModal = false;
    public int $price;
    public $type;
    public int $sale_unit_id;
    public $sale_units = [];

    public $rowId;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->authorize('posManagement', Product::class);

        $this->status = SaleStatus::DELIVERED->value;
        $this->payment_status = SalePaymentStatus::DUE->value;
        $this->paid_by = PaymentPaidBy::CASH->value;
    }

    // create customer
    public function createCustomer()
    {
        $this->authorize('create', Customer::class);
        $this->form->store();

        $this->success(__('Record has been created successfully'));
        $this->dispatch('close');
    }

    public function render()
    {
        $this->authorize('posManagement', Product::class);

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
            ->paginate($this->perPage);

        $accounts = Account::active()->pluck('name', 'id');

        return view('livewire.pos.pos-management', compact('products', 'accounts'));
    }

    public function addToCart(Product $product)
    {
        // Check if the product is already in the cart
        $existingItem = Cart::search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->id === $product->id;
        })->first();

        if ($existingItem) {
            $this->info(__('Product is already added in the cart.'));
        } else {
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->price,
                'options' => [
                    'cost' => $product->cost,
                    'sale_unit_id' => $product->sale_unit_id ?? $product->unit_id,
                ],
            ])->associate(Product::class);

            $this->success(__('Product added successfully.'));
        }
    }

    public function removeFromCart($rowId)
    {
        Cart::remove($rowId);

        $this->success(__('Item removed.'));

        return back();
    }

    public function updateQty(string $rowId, int|float $saleQty)
    {
        $item = Cart::get($rowId);
        // $inStockQty = (int) $item->model->qty;

        if ($saleQty > 0) {
            Cart::update($rowId, $saleQty);
            $this->success(__('Quantity updated successfully.'));
        } elseif ($saleQty <= 0) {
            $this->redirect(PosManagement::class, navigate: true);
            $this->error(__('Quantity must be greater than 0.'));
        }
    }

    public function updatePrice(string $rowId, int $salePrice)
    {
        $item = Cart::get($rowId);
        $productPrice = (int) $item->model->price; // product price

        // If new price is greater than or equal to product price then update price
        if ($salePrice > 0) {
            Cart::update($rowId, [
                'price' => $salePrice,
            ]);

            $this->success(__('Price updated.'));
        } else {
            $this->redirect(PosManagement::class, navigate: true);
            $this->error(__('Price must be greater than 0.'));
        }
    }

    public function updatedPaymentStatus($value)
    {
        if ($value === SalePaymentStatus::PAID->value) {
            $this->paid_amount = $this->cartTotal();
        } else {
            $this->paid_amount = 0;
        }
    }

    public function updatedCustomerId(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function showProductEditModal(string $rowId, Product $product)
    {
        $this->reset(['sale_unit_id', 'price']);
        $this->productEditModal = true;
        $this->product = $product;

        $this->type = $product->type;
        $this->sale_unit_id = $product->sale_unit_id ?? $product->unit_id;
        $this->price = $product->price;
        $this->sale_units = Unit::whereId($product->unit_id)
            ->orWhere('unit_id', $product->unit_id)
            ->active()
            ->pluck('name', 'id');

        $this->rowId = $rowId;
    }

    public function editProduct()
    {
        $this->validate([
            'sale_unit_id' => ['required', Rule::exists(Unit::class, 'id')],
        ]);

        DB::beginTransaction();

        try {
            Cart::update($this->rowId, [
                'options' => [
                    'cost' => $this->product->cost,
                    'sale_unit_id' => $this->sale_unit_id,
                ],
            ]);

            $this->product->update(['sale_unit_id' => $this->sale_unit_id]);

            DB::commit();
            $this->productEditModal = false;
            $this->success(__('Product sale unit has been updated.'));
        } catch (\Exception $e) {
            DB::rollback();
            $this->error($e->getMessage());
        }
    }

    public function createInvoice()
    {
        $rules = [
            'customer_id' => ['required', Rule::exists(Customer::class, 'id')],
            'status' => ['required', Rule::in(['ordered', 'pending', 'delivered'])],
            'payment_status' => ['required', Rule::in(['due', 'partial', 'paid'])],
            'details' => 'nullable',
        ];

        if (in_array($this->payment_status, ['partial', 'paid'])) {
            $rules['paid_by'] = ['required'];
            $rules['account_id'] = ['required', Rule::exists(Account::class, 'id')];
            $rules['paid_amount'] = [
                'required', 'int', 'gt:1', 'lte:'.$this->cartTotal(),
                function ($attribute, $value, $fail) {
                    if ($this->paid_by === PaymentPaidBy::DEPOSIT->value && isset($this->customer)) {
                        $customerDepositBalance = $this->customer->depositBalance();
                        if ($customerDepositBalance < $value) {
                            $fail('Ops! Customer\'s deposit balance is insufficient. Available balance '.$customerDepositBalance);
                        }
                    }
                },
            ];
        }

        $this->validate($rules);
        DB::beginTransaction();

        try {
            // Insert sale
            $sale = $this->customer->sales()->create([
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

            // Insert Sale Items
            foreach (Cart::content() as $item) {
                // Decrement product quantity based on sale unit
                $saleUnit = Unit::findOrFail($item->options['sale_unit_id']);
                $convertedQty = $saleUnit->convertQuantity($item->qty, $saleUnit->operator, $saleUnit->operation_value);

                if ($convertedQty !== null && $convertedQty > 0) {
                    $item->model->decrement('qty', $convertedQty * 100); // as I am using mutator in product qty

                    // Calculate the cost per item
                    $costPerUnit = $item->model->cost; // Cost per unit from the product
                    $totalCost = $costPerUnit * $convertedQty; // Total cost for the converted quantity
                    $costPerItemPerUnit = $totalCost / $item->qty; // Cost per item per unit(kg, gm, lb)
                } else {
                    Log::error('Invalid sale qty convertion.');
                }

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item->id,
                    'price' => $item->price,
                    'qty' => $item->qty,
                    'cost' => $costPerItemPerUnit,
                    'sale_unit_id' => $item->options['sale_unit_id'],
                ]);
            }

            // Insert Payment
            if ($this->payment_status === SalePaymentStatus::PARTIAL->value || $this->payment_status === SalePaymentStatus::PAID->value) {
                $sale->payments()->create([
                    'account_id' => $this->account_id,
                    'amount' => $this->paid_amount,
                    'reference' => 'Sale',
                    'type' => PaymentType::CREDIT->value,
                    'paid_by' => $this->paid_by,
                    'details' => $this->details,
                ]);

                // Increase customer expense
                if ($this->paid_by === PaymentPaidBy::DEPOSIT->value) {
                    $this->customer->increment('expense', $this->paid_amount);
                }
            }

            // Commit the transaction
            DB::commit();

            // Clear the cart & session data
            Cart::destroy();
            $this->invoice_no = $sale->invoice_no;

            $this->success(__('Sales generated successfully'));

            return $this->redirectRoute('admin.pos.create.invoice', ['invoice_no' => $this->invoice_no], navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating sale: '.$e->getMessage());
            $this->error(__('Something went wrong!'));
        }
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

    public function placeholder()
    {
        return view('livewire.placeholders.pos');
    }
}
