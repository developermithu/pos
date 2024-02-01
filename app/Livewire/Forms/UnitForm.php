<?php

namespace App\Livewire\Forms;

use App\Models\Unit;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UnitForm extends Form
{
    public ?Unit $unit;

    public string $name = '';
    public string $short_name = '';
    public int|string $unit_id = '';

    public function setUnit(Unit $unit)
    {
        $this->unit = $unit;

        $this->name = $unit->name;
        $this->short_name = $unit->short_name;
        $this->unit_id = $unit->unit_id ?? '';
    }

    public function store()
    {
        $this->validate();

        $unit_is_null = $this->unit_id === '' || $this->unit_id === null;

        Unit::create([
            'name' => $this->name,
            'short_name' => $this->short_name,
            'unit_id' => $unit_is_null ? null : $this->unit_id,
        ]);

        $this->reset();
    }

    public function update()
    {
        $this->validate();

        $unit_is_null = $this->unit_id === '' || $this->unit_id === null;

        $this->unit->update([
            'name' => $this->name,
            'short_name' => $this->short_name,
            'unit_id' => $unit_is_null ? null : $this->unit_id,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'short_name' => [
                'required',
                Rule::unique(Unit::class)->ignore($this->unit ?? null),
            ],
            'unit_id' => [
                'nullable',
                Rule::exists(Unit::class, 'id')->when($this->unit_id, function ($query) {
                    return $query;
                }),
            ],
        ];
    }
}
