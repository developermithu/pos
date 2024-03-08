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
    public ?int $unit_id = null;
    public ?string $operator = '*';
    public int|float|null $operation_value = 1;

    public function setUnit(Unit $unit)
    {
        $this->unit = $unit;

        $this->name = $unit->name;
        $this->short_name = $unit->short_name;
        $this->unit_id = $unit->unit_id ?? null;
        $this->operator = $unit->operator ?? null;
        $this->operation_value = $unit->operation_value ?? null;
    }

    public function store()
    {
        $this->validate();

        Unit::create([
            'name' => $this->name,
            'short_name' => $this->short_name,
            'unit_id' => $this->unit_id ?? null,
            'operator' => trim($this->operator),
            'operation_value' => $this->operation_value,
        ]);

        $this->reset();
    }

    public function update()
    {
        $this->validate();

        $this->unit->update([
            'name' => $this->name,
            'short_name' => $this->short_name,
            'unit_id' => $this->unit_id ?? null,
            'operator' => trim($this->operator),
            'operation_value' => $this->operation_value,
        ]);
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required'],
            'short_name' => [
                'required',
                Rule::unique(Unit::class)->ignore($this->unit ?? null),
            ],
            'unit_id' => [
                'nullable',
                // Rule::exists(Unit::class, 'id')->when($this->unit_id, function ($query) {
                //     return $query;
                // }),
            ],
        ];

        if (isset($this->unit_id)) {
            $rules['operator'] = ['required', 'string', 'regex:/^[\s*+\-\/]*$/']; // avoid extra slash (+, -, *, /)
            $rules['operation_value'] = ['required', 'numeric'];
        }

        return $rules;
    }
}
