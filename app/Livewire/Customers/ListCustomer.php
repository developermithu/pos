<?php

namespace App\Livewire\Customers;

use App\Enums\PaymentPaidBy;
use App\Enums\PaymentType;
use App\Enums\SalePaymentStatus;
use App\Models\Customer;
use App\Models\Deposit;
use App\Models\Sale;
use App\Traits\SearchAndFilter;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListCustomer extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    public $selected = [];

    // For clearing due
    public int $amount;
    public ?string $note = null;

    public bool $showDrawer = false;
    public string $customer_id;

    // Deposit Operations
    public Customer $customer;
    public bool $showModal = false;
    public int $deposit_amount;
    public ?string $details = null;

    public function render()
    {
        $this->authorize('viewAny', Customer::class);

        $search = $this->search ? '%'.trim($this->search).'%' : null;
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
            ->with('sales:id,total,paid_amount,customer_id')
            ->latest()
            ->paginate(10);

        return view('livewire.customers.list-customer', compact('customers'))->title(__('customer list'));
    }

    public function showDepositModal(Customer $customer)
    {
        $this->customer = $customer;
        $this->showModal = true;
    }

    public function addDeposit()
    {
        $this->validate([
            'deposit_amount' => ['required', 'integer', 'numeric', 'gt:0'],
            'details' => ['nullable', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {
            $this->customer->deposits()->create([
                'amount' => $this->deposit_amount,
                'details' => $this->details,
            ]);

            // increase the customer's deposit
            $this->customer->increment('deposit', $this->deposit_amount);
            DB::commit();

            $this->showModal = false;
            $this->reset(['deposit_amount', 'details']);
            $this->success(__('Deposit has been added.'));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            $this->error(__('Something went wrong.'));
        }

        return back();
    }

    public function forceDeleteDeposit(Deposit $deposit)
    {
        $this->authorize('forceDelete', $deposit);
        DB::beginTransaction();

        try {
            $depositable = $deposit->depositable;

            // If the depositable is a customer, decrease the customer's deposit
            if ($depositable instanceof Customer) {
                $depositable->decrement('deposit', $deposit->amount);
            }

            $deposit->forceDelete();

            DB::commit();
            $this->success(__('Record has been deleted permanently'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->error(__('Something went wrong.'));
        }
    }

    public function showDueModal(string $id)
    {
        $this->customer_id = $id;
        $this->showDrawer = true;
    }

    public function clearDue()
    {
        $this->validate([
            'amount' => ['required', 'integer', 'numeric', 'gt:0'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {
            $sales = Sale::select('id', 'total', 'paid_amount', 'payment_status')
                ->where('payment_status', '!=', SalePaymentStatus::PAID)
                ->where('customer_id', $this->customer_id)
                ->oldest()
                ->get();

            foreach ($sales as $sale) {
                if ($this->amount <= 0) {
                    break;
                }

                $dueAmount = $sale->total - $sale->paid_amount;

                if ($this->amount >= $dueAmount) {
                    $paid_amount = $dueAmount;
                    $payment_status = SalePaymentStatus::PAID->value;
                } else {
                    $paid_amount = $this->amount;
                    $payment_status = SalePaymentStatus::PARTIAL->value;
                }

                $sale->payments()->create([
                    'account_id' => 1, // cash
                    'amount' => $paid_amount,
                    'reference' => Str::random(),
                    'type' => PaymentType::CREDIT,
                    'note' => $this->note,
                    'paid_by' => PaymentPaidBy::CASH,
                ]);

                $sale->paid_amount += $paid_amount;
                $sale->payment_status = $payment_status;
                $sale->save();

                $this->amount -= $paid_amount; // Subtract the paid amount from this amount
            }

            DB::commit();

            $this->showDrawer = false;
            $this->reset(['amount', 'note']);
            $this->success(__('Due has been cleared.'));
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
}
