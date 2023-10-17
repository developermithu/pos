<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListCustomer extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public $search = "";
    public $selected = [];

    public function deleteSelected()
    {
        $customers = Customer::whereKey($this->selected);
        $customers->delete();

        session()->flash('status', 'Selected records deleted successfully.');
        return back();
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        session()->flash('status', 'Record deleted successfully.');
        return back();
    }

    public function render()
    {
        $customers = Customer::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('address', 'like', '%' . $this->search . '%')
            ->orWhere('phone_number', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.customers.list-customer', compact('customers'));
    }
}
