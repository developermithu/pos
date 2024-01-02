<?php

namespace App\Livewire\Stores;

use App\Livewire\Forms\StoreForm;
use App\Models\Store;
use Livewire\Component;
use Mary\Traits\Toast;

class EditStore extends Component
{
    use Toast;
    public StoreForm $form;

    public function mount(Store $store)
    {
        $this->authorize('update', $store);
        $this->form->setStore($store);
    }

    public function save()
    {
        $this->form->update();

        $this->success(__('Record has been updated successfully'));
        return $this->redirect(ListStore::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.stores.edit-store')
            ->title(__('update store'));
    }
}
