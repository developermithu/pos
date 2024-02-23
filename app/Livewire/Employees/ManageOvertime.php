<?php

namespace App\Livewire\Employees;

use App\Livewire\Forms\OvertimeForm;
use App\Models\Overtime;
use App\Traits\SearchAndFilter;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ManageOvertime extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    public OvertimeForm $form;

    public bool $showDrawer = false;
    public bool $isEditing = false;

    public function mount()
    {
        $this->form->date = now()->format('Y-m-d');
    }

    public function render()
    {
        $this->authorize('viewAny', Overtime::class);

        $overtimes = Overtime::query()
            ->when($this->search, function ($query) {
                $query->whereHas('employee', function ($query) {
                    $query->where('name', 'like', "%$this->search%");
                });
            })
            ->latest()
            ->with('employee:id,name')
            ->paginate(10);

        return view('livewire.employees.manage-overtime', compact('overtimes'))
            ->title(__('manage overtime works'));
    }

    public function showEditModal(Overtime $overtime)
    {
        $this->showDrawer = true;
        $this->isEditing = true;
        $this->form->resetValidation();
        $this->form->setOvertime($overtime);
    }

    public function create()
    {
        $this->authorize('create', Overtime::class);

        $this->form->store();
        $this->form->reset();
        $this->showDrawer = false;
        $this->success(__('Record has been created successfully'));
    }

    public function save()
    {
        $this->authorize('update', $this->form->overtime ?? '');

        $this->form->update();
        $this->form->reset();
        $this->showDrawer = false;
        $this->isEditing = false;
        $this->success(__('Record has been updated successfully'));
    }

    public function forceDelete(Overtime $overtime)
    {
        $this->authorize('forceDelete', $overtime);
        $overtime->forceDelete();

        $this->success(__('Record has been deleted permanently'));

        return back();
    }
}
