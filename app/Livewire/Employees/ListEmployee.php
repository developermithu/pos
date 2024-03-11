<?php

namespace App\Livewire\Employees;

use App\Models\Employee;
use App\Models\Payment;
use App\Traits\SearchAndFilter;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListEmployee extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    public $selected = [];

    public function deleteSelected()
    {
        $this->authorize('bulkDelete', Employee::class);

        Employee::destroy($this->selected);

        $this->success(__('Selected records has been deleted'));

        return back();
    }

    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);
        $employee->delete();

        $this->success(__('Record has been deleted successfully'));

        return back();
    }

    public function forceDelete($id)
    {
        $employee = Employee::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $employee);
        $employee->forceDelete();

        $this->success(__('Record has been deleted permanently'));

        return back();
    }

    public function restore($id)
    {
        $employee = Employee::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $employee);
        $employee->restore();

        $this->success(__('Record has been restored successfully'));

        return back();
    }

    public function render()
    {
        $this->authorize('viewAny', Employee::class);

        $search = $this->search ? '%'.trim($this->search).'%' : null;

        $searchableFields = ['name', 'father_name', 'address', 'phone_number', 'gender'];

        $employees = Employee::query()
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

        return view('livewire.employees.list-employee', compact('employees'))->title(__('employee list'));
    }

    //===== Employees Payment Management ======//
    public function destroyAdvancePayment(Payment $payment)
    {
        $this->authorize('delete', $payment);
        $payment->delete();

        $this->success(__('Record has been deleted successfully'));

        return back();
    }

    public function restoreAdvancePayment($id)
    {
        $payment = Payment::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $payment);
        $payment->restore();

        $this->success(__('Record has been restored successfully'));

        return back();
    }

    public function forceDeleteAdvancePayment($id)
    {
        $payment = Payment::onlyTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $payment);

        $payment->forceDelete();
        $this->success(__('Record has been deleted permanently'));

        return back();
    }
}
