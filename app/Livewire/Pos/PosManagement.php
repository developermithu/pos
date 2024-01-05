<?php

namespace App\Livewire\Pos;

use App\Enums\SalePaymentStatus;
use App\Enums\SaleStatus;
use App\Livewire\Forms\CustomerForm;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class PosManagement extends Component
{
    use WithPagination, Toast;

    public CustomerForm $form;

    public $perPage = 10;

    #[Url(as: 'q')]
    public string $search = "";

    // Creating sale properties
    public int|string $customer_id = '';
    public string $status;
    public string $payment_status;
    public ?string $paid_by = 'cash';
    public ?int $received_amount;
    public ?int $paid_amount = 0;
    public ?string $note = null;

    public $invoice_no;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->authorize('posManagement', Product::class);

        $this->status = SaleStatus::DELIVERED->value;
        $this->payment_status = SalePaymentStatus::PENDING->value;
        $this->received_amount = $this->cartTotal();
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
            ->paginate($this->perPage);

        return view('livewire.pos.pos-management', compact('products'))->title(__('pos'));
    }

    public function addToCart(Product $product)
    {
        Cart::add(
            $product->id,
            $product->name,
            1,
            $product->price,
        )->associate(Product::class);

        $this->success(__('Product added successfully.'));
        return back();
    }

    public function increaseQty($rowId)
    {
        $item = Cart::get($rowId);
        Cart::update($rowId, $item->qty + 1);

        $this->success(__('Quantity increased.'));
        return back();
    }

    public function decreaseQty($rowId)
    {
        $item = Cart::get($rowId);

        if ($item->qty === 1) {
            Cart::remove($rowId);
            $this->success(__('Item removed.'));
        } else {
            Cart::update($rowId, $item->qty - 1);
            $this->success(__('Quantity decreased.'));
        }

        return back();
    }

    public function removeFromCart($rowId)
    {
        Cart::remove($rowId);

        $this->success(__('Item removed.'));
        return back();
    }

    public function createInvoice()
    {
        $this->validate([
            'customer_id' => [
                'required',
                Rule::exists(Customer::class, 'id')
            ],
            'status' => 'nullable',
            'payment_status' => 'nullable',
            'paid_by' => 'nullable',
            'received_amount' => 'nullable|numeric',
            'paid_amount' => 'nullable|numeric',
            'note' => 'nullable',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Insert sale
            $sale = Sale::create([
                'customer_id' => $this->customer_id,
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

            // Insert Sale Items
            foreach (Cart::content() as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item->id,
                    'price' => $item->price,
                    'qty' => $item->qty,
                ]);
            }

            // Insert Payment
            if ($this->payment_status === SalePaymentStatus::PARTIAL->value || $this->payment_status === SalePaymentStatus::PAID->value) {
                Payment::create([
                    'account_id' => 1,
                    'amount' => $this->paid_amount,
                    'payment_method' => $this->paid_by,
                    'reference' => 'SR-' . date('Ymd') . '-' . rand(00000, 99999),
                    'paymentable_id' => $sale->id,
                    'paymentable_type' => Sale::class,
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Clear the cart & session data
            Cart::destroy();
            $this->invoice_no = $sale->invoice_no;

            // Sending invoice email
            $this->success(__('Sales generated successfully'));
            return $this->redirectRoute('admin.pos.create.invoice', ['invoice_no' => $this->invoice_no], navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Error creating sale: ' . $e->getMessage());

            $this->error(__('Something went wrong!'));
            return back();
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
}
