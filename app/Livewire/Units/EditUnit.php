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

    public function mount(Unit $unit)
    {
        $this->authorize('update', $unit);
        $this->form->setUnit($unit);
    }

    public function save()
    {
        $this->form->update();

        $this->success(__('Record has been updated successfully'));
        return $this->redirect(ListUnit::class, navigate: true);
    }

    public function render()
    {
        return view('livewire.units.edit-unit')
            ->title(__('update unit'));
    }
}
