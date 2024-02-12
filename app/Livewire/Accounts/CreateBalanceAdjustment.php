<?php

namespace App\Livewire\Accounts;

use App\Livewire\Forms\BalanceAdjustmentForm;
use App\Models\Account;
use App\Models\BalanceAdjustment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Mary\Traits\Toast;

class CreateBalanceAdjustment extends Component
{
    use Toast;

    public BalanceAdjustmentForm $form;

    public function mount()
    {
        $this->authorize('create', BalanceAdjustment::class);
        $this->form->date = now()->format('Y-m-d');
    }

    public function save()
    {
        // If we use this in form then it will catch exception
        // instead of showing validation errors
        // $this->form::rules() will also work
        $this->validate(
            BalanceAdjustmentForm::rules(),
            [],
            BalanceAdjustmentForm::attributes()
        );

        DB::beginTransaction();

        try {
            $this->form->store();

            DB::commit();
            $this->success(__('Record has been created successfully'));

            return $this->redirect(ListBalanceAdjustment::class, navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            $this->error(__('Something went wrong!'));
        }

        return back();
    }

    public function render()
    {
        $accounts = Account::active()->pluck('name', 'id');

        return view('livewire.accounts.create-balance-adjustment', compact('accounts'))
            ->title(__('create balance adjustment'));
    }
}
