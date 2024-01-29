<?php

namespace App\Livewire\Stores;

use App\Livewire\Forms\StoreForm;
use App\Models\Store;
use App\Traits\SearchAndFilter;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListStore extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    public StoreForm $form;

    public function create()
    {
        $this->authorize('create', Store::class);
        $this->form->store();

        $this->success(__('Record has been created successfully'));
        $this->dispatch('close');
    }

    public function destroy(Store $store)
    {
        $this->authorize('delete', $store);
        $store->delete();

        $this->success(__('Record has been deleted successfully'));

        return back();
    }

    public function forceDelete($id)
    {
        $store = Store::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $store);
        $store->forceDelete();

        $this->success(__('Record has been deleted permanently'));

        return back();
    }

    public function restore($id)
    {
        $store = Store::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $store);
        $store->restore();

        $this->success(__('Record has been restored successfully'));

        return back();
    }

    public function render()
    {
        $this->authorize('viewAny', Store::class);

        $search = $this->search ? '%'.trim($this->search).'%' : null;
        $searchableFields = ['name', 'location'];

        $stores = Store::query()
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

        return view('livewire.stores.list-store', compact('stores'))
            ->title(__('store list'));
    }
}
