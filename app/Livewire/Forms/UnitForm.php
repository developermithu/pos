<?php

namespace App\Livewire\Forms;

use App\Models\Unit;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UnitForm extends Form
{
    public ?Unit $unit;

    public string $name = '';
    public string $short_name = '';

    public function setUnit(Unit $unit)
    {
        $this->unit = $unit;
        
        $this->name = $unit->name;
        $this->short_name = $unit->short_name;
    }

    public function store()
    {
        $this->validate();
        Unit::create($this->only(['name', 'short_name']));

        $this->reset();
    }

    public function update()
    {
        $this->validate();
        $this->unit->update($this->only(['name', 'short_name']));
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'short_name' => [
                'required',
                Rule::unique(Unit::class)->ignore($this->unit ?? null),
            ],
        ];
    }
}
