<?php

namespace App\Livewire\Units;

use App\Livewire\Forms\UnitForm;
use App\Models\Unit;
use Livewire\Component;
use Mary\Traits\Toast;

class EditUnit extends Component
{
    use Toast;

    public UnitForm $form;

    public $unit_id;
    public $base_unit_id;

    public function mount(Unit $unit)
    {
        $this->authorize('update', $unit);
        $this->form->setUnit($unit);

        $this->unit_id = $unit->id;
        $this->base_unit_id = $unit->unit_id;
    }

    public function updatedFormUnitId($value)
    {
        $this->base_unit_id = $value;

        if (is_null($value)) {
            $this->form->operator = '*';
            $this->form->operation_value = 1;
        }
    }

    public function save()
    {
        $this->form->update();

        $this->success(__('Record has been updated successfully'));

        return $this->redirect(ListUnit::class, navigate: true);
    }

    public function render()
    {
        $baseUnits = Unit::whereUnitId(null)->pluck('name', 'id');

        return view('livewire.units.edit-unit', compact('baseUnits'))
            ->title(__('update unit'));
    }
}
