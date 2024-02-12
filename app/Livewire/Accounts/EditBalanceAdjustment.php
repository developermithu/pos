<?php

namespace App\Livewire\Accounts;

use App\Livewire\Forms\BalanceAdjustmentForm;
use App\Models\Account;
use App\Models\BalanceAdjustment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Mary\Traits\Toast;

class EditBalanceAdjustment extends Component
{
    use Toast;

    public BalanceAdjustmentForm $form;

    public function mount(BalanceAdjustment $balanceAdjustment)
    {
        $this->authorize('update', $balanceAdjustment);
        $this->form->setBalanceAdjustment($balanceAdjustment);
    }

    public function save()
    {
        $this->validate(
            BalanceAdjustmentForm::rules(),
            [],
            BalanceAdjustmentForm::attributes()
        );

        DB::beginTransaction();

        try {
            $this->form->update();

            DB::commit();
            $this->success(__('Record has been updated successfully'));
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

        return view('livewire.accounts.edit-balance-adjustment', compact('accounts'))
            ->title(__('update balance adjustment'));
    }
}
