<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use App\Traits\SearchAndFilter;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

#[Lazy]
class ListSupplier extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    public $selected = [];

    public function deleteSelected()
    {
        $this->authorize('bulkDelete', Supplier::class);

        Supplier::destroy($this->selected);

        $this->success(__('Selected records has been deleted'));

        return back();
    }

    public function destroy(Supplier $supplier)
    {
        $this->authorize('delete', $supplier);
        $supplier->delete();

        $this->success(__('Record has been deleted successfully'));

        return back();
    }

    public function forceDelete($id)
    {
        $supplier = Supplier::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $supplier);
        $supplier->forceDelete();

        $this->success(__('Record has been deleted permanently'));

        return back();
    }

    public function restore($id)
    {
        $supplier = Supplier::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $supplier);
        $supplier->restore();

        $this->success(__('Record has been restored successfully'));

        return back();
    }

    public function render()
    {
        $this->authorize('viewAny', Supplier::class);

        $search = $this->search ? '%'.trim($this->search).'%' : null;
        $searchableFields = ['name', 'company_name', 'address', 'phone_number'];

        $suppliers = Supplier::query()
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
            ->latest()
            ->paginate(10);

        return view('livewire.suppliers.list-supplier', compact('suppliers'))
            ->title(__('supplier list'));
    }

    public function placeholder()
    {
        return view('livewire.placeholders.supplier-page');
    }
}
