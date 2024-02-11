<?php

namespace App\Livewire\Customers;

use App\Enums\PaymentType;
use App\Enums\SalePaymentStatus;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Sale;
use App\Traits\SearchAndFilter;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Lazy]
class ListCustomer extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    public $selected = [];

    // For clearing due
    public int $amount;
    public ?string $note = null;

    public function render()
    {
        $this->authorize('viewAny', Customer::class);

        $search = $this->search ? '%' . trim($this->search) . '%' : null;
        $searchableFields = ['name', 'company_name', 'address', 'phone_number'];

        $customers = Customer::query()
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->when($this->filterByTrash, function ($query, $value) {
                if ($value === 'onlyTrashed') {
                    $query->onlyTrashed();
                } elseif ($value === 'withTrashed') {
                    $query->withTrashed();
                }
            })
            ->with('sales:id,total,paid_amount,customer_id', 'deposits.account:id,name')
            ->latest()
            ->paginate(10);

        return view('livewire.customers.list-customer', compact('customers'))->title(__('customer list'));
    }

    // Clearing customer due 
    public function clearDue()
    {
        $this->validate([
            'amount' => ['required', 'integer', 'numeric', 'gt:0'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            DB::beginTransaction();

            $sales = Sale::select('id', 'total', 'paid_amount', 'payment_status')
                ->where('payment_status', '!=', SalePaymentStatus::PAID)
                ->oldest()
                ->get();

            foreach ($sales as $sale) {
                if ($this->amount <= 0) break;

                $dueAmount = $sale->total - $sale->paid_amount;

                if ($this->amount >= $dueAmount) {
                    $paid_amount = $dueAmount;
                    $payment_status = SalePaymentStatus::PAID->value;
                } else {
                    $paid_amount = $this->amount;
                    $payment_status = SalePaymentStatus::PARTIAL->value;
                }

                Payment::create([
                    'account_id' => 1, // cash
                    'amount' => $paid_amount,
                    'reference' => Str::random(),
                    'type' => PaymentType::CREDIT,
                    'note' => $this->note,
                    'paymentable_id' => $sale->id,
                    'paymentable_type' => Sale::class,
                ]);

                $sale->paid_amount += $paid_amount;
                $sale->payment_status = $payment_status;
                $sale->save();

                $this->amount -= $paid_amount; // Subtract the paid amount from this amount

                DB::commit();

                $this->reset(['amount', 'note']);
                $this->dispatch('close');
                $this->success(__('Due has been cleared.'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            $this->error(__('An error occurred while clearing due. Please try again.'));
        }

        return back();
    }

    public function deleteSelected()
    {
        $this->authorize('bulkDelete', Customer::class);
        Customer::destroy($this->selected);

        $this->success(__('Selected records has been deleted'));

        return back();
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);
        $customer->delete();

        $this->success(__('Record has been deleted successfully'));

        return back();
    }

    public function forceDelete($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $customer);

        try {
            $customer->forceDelete();
            $this->success(__('Record has been deleted permanently'));
        } catch (QueryException $e) {
            // Check if it's a foreign key constraint violation
            if ($e->getCode() == 23000) {
                $this->warning(__('Failed to delete customer. There are existing sale records linked to it.'), timeout: 5000);
            }
        }

        return back();
    }

    public function restore($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $customer);
        $customer->restore();

        $this->success(__('Record has been restored successfully'));

        return back();
    }

    //===== Customer Deposit Management ======//
    public function destroyDeposit(Payment $deposit)
    {
        $this->authorize('delete', $deposit);

        try {
            DB::beginTransaction();
            $paymentable = $deposit->paymentable;
            // Subtract amount from the customer deposit
            $paymentable->deposit -= $deposit->amount;

            $paymentable->save();
            $deposit->delete();

            DB::commit();
            $this->success(__('Record has been deleted successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            $this->error(__('Something went wrong!'));
        }

        return back();
    }

    public function restoreDeposit($id)
    {
        $deposit = Payment::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $deposit);

        try {
            DB::beginTransaction();
            $paymentable = $deposit->paymentable;
            // Addition amount in customer deposit
            $paymentable->deposit += $deposit->amount;

            $paymentable->save();
            $deposit->restore();

            DB::commit();
            $this->success(__('Record has been restored successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            $this->error(__('Something went wrong!'));
        }

        return back();
    }

    public function forceDeleteDeposit($id)
    {
        $deposit = Payment::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $deposit);

        $deposit->forceDelete();
        $this->success(__('Record has been deleted permanently'));

        return back();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.customer-page');
    }
}
