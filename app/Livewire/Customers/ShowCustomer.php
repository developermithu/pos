<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;

class ShowCustomer extends Component
{
    public Customer $customer;

    public function mount(Customer $customer)
    {
        $this->authorize('view', $customer);
        $this->customer = $customer->load('sales', 'deposits');
    }

    public function render()
    {
        $payments = $this->customer->sales()
            ->with(['payments' => function ($query) {
                $query->with('account:id,name')->whereNull('deleted_at');
            }])
            ->get()
            ->flatMap(function ($sale) {
                return $sale->payments;
            })
            ->sortByDesc('created_at');

        return view('livewire.customers.show-customer', compact('payments'))
            ->title(__('customer details'));
    }
}
