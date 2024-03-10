<?php

namespace App\Console\Commands;

use App\Models\Supplier;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SupplierUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'supplier:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update supplier ulid';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Generate ulid
        Supplier::query()->each(function ($customer) {
            $customer->update(['ulid' => (string) strtolower(Str::ulid())]);
        });

        $this->info('Supplier updated successfully!');
    }
}
