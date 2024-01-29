<?php

namespace App\Livewire\Forms;

use App\Models\Store;
use Illuminate\Validation\Rule;
use Livewire\Form;

class StoreForm extends Form
{
    public ?Store $store;

    public string $name = '';
    public string $location = '';

    public function setStore(Store $store)
    {
        $this->store = $store;
        $this->name = $store->name;
        $this->location = $store->location;
    }

    public function store()
    {
        $this->validate();
        Store::create($this->only(['name', 'location']));

        $this->reset();
    }

    public function update()
    {
        $this->validate();
        $this->store->update($this->only(['name', 'location']));
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique(Store::class)->ignore($this->store ?? null),
            ],
            'location' => 'required',
        ];
    }
}
