<?php

namespace App\Console\Commands;

use App\Enums\PaymentPaidBy;
use App\Enums\PaymentType;
use App\Models\Customer;
use App\Models\Deposit;
use App\Models\Payment;
use App\Models\Supplier;
use Illuminate\Console\Command;

class AddDepositPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:deposit-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add deposit payment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Supplier::all()->each(function ($supplier) {
            foreach ($supplier->deposits as $deposit) {
                Payment::create([
                    'account_id' => 1, //cash
                    'amount' => $deposit->amount,
                    'reference' => 'Supplier deposit',
                    'details' => $deposit->details,
                    'type' => PaymentType::DEBIT,
                    'paid_by' => PaymentPaidBy::CASH,
                    'paymentable_id' => $deposit->id,
                    'paymentable_type' => Deposit::class,
                    // 'created_at' => $deposit->created_at,
                ]);
            }
        });

        Customer::all()->each(function ($customer) {
            foreach ($customer->deposits as $deposit) {
                Payment::create([
                    'account_id' => 1, //cash
                    'amount' => $deposit->amount,
                    'reference' => 'Customer deposit',
                    'details' => $deposit->details,
                    'type' => PaymentType::CREDIT,
                    'paid_by' => PaymentPaidBy::CASH,
                    'paymentable_id' => $deposit->id,
                    'paymentable_type' => Deposit::class,
                    // 'created_at' => $deposit->created_at,
                ]);
            }
        });

        $this->info('Payment updated successfully!');
    }
}
