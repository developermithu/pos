<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IncrementEmployeesBalance extends Command
{
    protected $signature = 'employee:increment-balance';
    protected $details = 'Increment employees balance monthly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::beginTransaction();

        try {
            $firstDayLastMonth = now()->subMonth()->startOfMonth();
            $lastDayLastMonth = now()->subMonth()->endOfMonth();

            $lastMonthWorkingDays = Attendance::query()
                ->whereBetween('date', [$firstDayLastMonth, $lastDayLastMonth])
                ->distinct('date') // unique date entry
                ->count();

            foreach (Employee::all() as $key => $employee) {
                $salary = $employee->basic_salary;

                $perDayEarning = $salary / $lastMonthWorkingDays;
                $presentDays = $employee->lastMonthTotalPresent();

                $lastMonthTotalEarning = (int) round($presentDays * $perDayEarning);

                // Increment balance
                $employee->balance += $lastMonthTotalEarning;
                $employee->last_balance_increased_at = now();
                $employee->balance_increased_amount = $lastMonthTotalEarning;
                $employee->save();

                Log::info("Employees: $employee->name, Balance increased amount: $employee->balance_increased_amount, Last balance increased at: $employee->last_balance_increased_at");
            }

            DB::commit();
            $this->info('Employees balance incremented successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed incrementing employees' balance: {$e->getMessage()}");
            $this->error('Failed incrementing employees balance.');

            // Retry after 60 seconds
            // $this->release(60);
        }
    }
}
