<?php

namespace App\Livewire\Employees;

use App\Enums\PaymentType;
use App\Models\Account;
use App\Models\Employee;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Mary\Traits\Toast;

class AddAdvancePayment extends Component
{
    use Toast;
    public Employee $employee;

    public int|string $account_id = '';
    public ?int $amount;
    public ?string $note = null;

    public function mount(Employee $employee)
    {
        $this->authorize('update', $employee);
        $this->employee = $employee;
    }

    public function addAdvancePayment()
    {
        $this->authorize('create', employee::class);

        $this->validate();

        DB::beginTransaction();

        try {
            // Create Payment
            $payment = Payment::create([
                'account_id' => $this->account_id,
                'amount' => $this->amount,
                'reference' => 'Payroll-' . date('Ymd') . '-' . rand(11111, 99999),
                'note' => $this->note,
                'type' => PaymentType::DEBIT->value,
                'paymentable_id' => $this->employee->id,
                'paymentable_type' => Employee::class,
            ]);

            DB::commit();

            $this->success(__('Record has been created successfully'));

            return $this->redirect(ListEmployee::class, navigate: true);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            $this->error(__('Something went wrong!'));

            return back();
        }
    }

    public function render()
    {
        $accounts = Account::active()->pluck('name', 'id');

        return view('livewire.employees.add-advance-payment', compact('accounts'))
            ->title(__('add advance payment'));
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'integer', 'gt:0'],
            'account_id' => ['required', Rule::exists(Account::class, 'id')],
            'note' => ['nullable', 'max:255'],
        ];
    }
}
