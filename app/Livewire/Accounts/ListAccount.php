<?php

namespace App\Livewire\Accounts;

use App\Livewire\Forms\AccountForm;
use App\Models\Account;
use App\Traits\SearchAndFilter;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ListAccount extends Component
{
    use SearchAndFilter, Toast, WithPagination;

    public AccountForm $form;

    public function create()
    {
        $this->authorize('create', Account::class);
        $this->form->store();

        $this->success(__('Record has been created successfully'));
        $this->dispatch('close');
    }

    public function destroy(string $ulid)
    {
        $account = Account::whereUlid($ulid)->firstOrFail();
        $this->authorize('delete', $account);

        // Cashbook 1 can not be delete
        if ($account->id !== 1) {
            $account->delete();
            $this->success(__('Record has been deleted successfully'));
        } else {
            $this->error(__('You can not delete this main account.'));
        }
    }

    public function forceDelete(string $ulid)
    {
        $account = Account::onlyTrashed()->whereUlid($ulid)->firstOrFail();

        $this->authorize('forceDelete', $account);
        $account->forceDelete();
        $this->success(__('Record has been deleted permanently'));
    }

    public function restore(string $ulid)
    {
        $account = Account::onlyTrashed()->whereUlid($ulid)->firstOrFail();

        $this->authorize('restore', $account);
        $account->restore();
        $this->success(__('Record has been restored successfully'));
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
                if ($value === 'onlyTrashed') {
                    $query->onlyTrashed();
                } elseif ($value === 'withTrashed') {
                    $query->withTrashed();
                }
            })
            ->oldest()
            ->with('payments')
            ->paginate(10);

        return view('livewire.accounts.list-account', compact('accounts'))
            ->title(__('account list'));
    }
}
