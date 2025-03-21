<?php

namespace App\Livewire\Units;

use App\Livewire\Forms\UnitForm;
use App\Models\Unit;
use App\Traits\SearchAndFilter;
use Illuminate\Database\QueryException;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListUnit extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    public UnitForm $form;
    public $unit_id;

    public function toggleUnitStatus(Unit $unit)
    {
        $unit->is_active = !$unit->is_active;
        $unit->save();
        $this->redirect(ListUnit::class, navigate: true);
    }

    public function create()
    {
        $this->authorize('create', Unit::class);
        $this->form->store();

        $this->success(__('Record has been created successfully'));
        $this->dispatch('close');
    }

    public function updatedFormUnitId($value)
    {
        $this->unit_id = $value;

        if (is_null($value)) {
            $this->form->operator = '*';
            $this->form->operation_value = 1;
        }
    }

    public function destroy(Unit $unit)
    {
        $this->authorize('delete', $unit);
        $unit->delete();

        $this->success(__('Record has been deleted successfully'));
    }

    public function forceDelete($id)
    {
        $unit = Unit::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $unit);

        try {
            $unit->forceDelete();
            $this->success(__('Record has been deleted permanently'));
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                $this->warning(__('Failed to delete unit. There are existing product records linked to it.'), timeout: 5000);
            }
        }

        return back();
    }

    public function restore($id)
    {
        $unit = Unit::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $unit);
        $unit->restore();

        $this->success(__('Record has been restored successfully'));

        return back();
    }

    public function render()
    {
        $this->authorize('viewAny', Unit::class);

        $search = $this->search ? '%' . trim($this->search) . '%' : null;
        $searchableFields = ['name', 'short_name'];

        $units = Unit::query()
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
            ->with('baseUnit')
            ->latest()
            ->paginate(10);

        $baseUnits = Unit::whereUnitId(null)->pluck('name', 'id');

        return view('livewire.units.list-unit', compact('units', 'baseUnits'))
            ->title(__('unit list'));
    }
}
