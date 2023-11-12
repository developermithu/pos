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

    #[Url(as: 'records')]
    public $filterByTrash;

    public $selected = [];

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['filterByTrash', 'search'])) {
            $this->resetPage();
        }
    }

    public function clear()
    {
        $this->filterByTrash = '';
    }

    public function deleteSelected()
    {
        $customers = Customer::whereKey($this->selected);
        $customers->delete();

        session()->flash('status', __('Selected records has been deleted'));
        return back();
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        session()->flash('status', __('Record has been deleted successfully'));
        return back();
    }

    public function forceDelete($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $customer->forceDelete();

        session()->flash('status', __('Record has been deleted permanently'));
        return back();
    }

    public function restore($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $customer->restore();

        session()->flash('status', __('Record has been restored successfully'));
        return back();
    }

    public function render()
    {
        $search = $this->search ? '%' . trim($this->search) . '%' : null;
        $searchableFields = ['name', 'address', 'phone_number'];

        $customers = Customer::query()
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->when($this->filterByTrash, function ($query, $value) {
                if ($value === "onlyTrashed") {
                    $query->onlyTrashed();
                } elseif ($value === "withTrashed") {
                    $query->withTrashed();
                }
            })
            ->latest()
            ->paginate(10);

        return view('livewire.customers.list-customer', compact('customers'))->title(__('customer list'));
    }
}
