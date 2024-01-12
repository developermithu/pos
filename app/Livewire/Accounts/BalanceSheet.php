<?php

namespace App\Livewire\Accounts;

use App\Models\Account;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\Sale;
use Livewire\Component;

class BalanceSheet extends Component
{
    public function render()
    {
        $accounts = Account::all();

        $debit = [];
        $credit = [];

        foreach ($accounts as $account) {
            $payment_recieved = Payment::wherePaymentableType(Sale::class)->whereAccountId($account->id)->sum('amount');
            $payment_sent = Payment::wherePaymentableType(Purchase::class)->whereAccountId($account->id)->sum('amount');

            $expenses = Expense::whereAccountId($account->id)->sum('amount');

            $credit[] = $payment_recieved + $account->initial_balance;
            $debit[] = $payment_sent;
        }

        dd($expenses);

        // foreach ($accounts as $account) {
        //     $payment_recieved = Payment::whereNotNull('sale_id')->where('account_id', $account->id)->sum('amount');
        //     $payment_sent = Payment::whereNotNull('purchase_id')->where('account_id', $account->id)->sum('amount');
        //     $returns = DB::table('returns')->where('account_id', $account->id)->sum('grand_total');
        //     $return_purchase = DB::table('return_purchases')->where('account_id', $account->id)->sum('grand_total');
        //     $expenses = DB::table('expenses')->where('account_id', $account->id)->sum('amount');
        //     $payrolls = DB::table('payrolls')->where('account_id', $account->id)->sum('amount');
        //     $sent_money_via_transfer = MoneyTransfer::where('from_account_id', $account->id)->sum('amount');
        //     $recieved_money_via_transfer = MoneyTransfer::where('to_account_id', $account->id)->sum('amount');

        //     $credit[] = $payment_recieved + $return_purchase + $recieved_money_via_transfer + $account->initial_balance;
        //     $debit[] = $payment_sent + $returns + $expenses + $payrolls + $sent_money_via_transfer;
        // }


        return view('livewire.accounts.balance-sheet');
    }
}
