<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Traits\SearchAndFilter;
use Illuminate\Database\QueryException;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListCustomer extends Component
{
    use WithPagination, Toast, SearchAndFilter;

    public $selected = [];

    public function deleteSelected()
    {
        $this->authorize('bulkDelete', Customer::class);

        $customers = Customer::whereKey($this->selected);
        $customers->delete();

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
                $this->warning(__('Cannot delete customer. Related sales records exist.'));
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

    public function render()
    {
        $this->authorize('viewAny', Customer::class);

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
