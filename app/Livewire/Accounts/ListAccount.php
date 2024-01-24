<?php

namespace App\Livewire\Accounts;

use App\Livewire\Forms\AccountForm;
use App\Models\Account;
use App\Models\AdvancedSalary;
use App\Traits\SearchAndFilter;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListAccount extends Component
{
    use WithPagination, Toast, SearchAndFilter;

    public AccountForm $form;

    public function create()
    {
        $this->authorize('create', Account::class);
        $this->form->store();

        $this->success(__('Record has been created successfully'));
        $this->dispatch('close');
    }

    public function destroy(Account $account)
    {
        $this->authorize('delete', $account);
        $account->delete();

        $this->success(__('Record has been deleted successfully'));
        return back();
    }

    public function forceDelete($id)
    {
        $account = Account::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $account);
        $account->forceDelete();

        $this->success(__('Record has been deleted permanently'));
        return back();
    }

    public function restore($id)
    {
        $account = Account::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $account);
        $account->restore();

        $this->success(__('Record has been restored successfully'));
        return back();
    }

    public function render()
    {
        $this->authorize('viewAny', Account::class);

        $search = $this->search ? '%' . trim($this->search) . '%' : null;
        $searchableFields = ['account_no', 'name'];

        $accounts = Account::query()
            ->when($search, function ($query) use ($searchableFields, $search) {
                $query->where(function ($query) use ($searchableFields, $search) {
                    foreach ($searchableFields as $field) {
                        $query->orWhere($field, 'like', $search);
                    }
                });
            })
            ->when($this->filterByTrash, function ($query, $value) {
                if ($value === "onlyTrashed") {
                    $query->onlyTrashed();
                } elseif ($value === "withTrashed") {
                    $query->withTrashed();
                }
            })
            ->latest()
            ->paginate(10);

        return view('livewire.accounts.list-account', compact('accounts'))
            ->title(__('account list'));
    }
}
