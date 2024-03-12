<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('customers', 'initial_due')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->integer('initial_due')->nullable()->after('expense');
            });
        }

        if (!Schema::hasColumn('suppliers', 'initial_due')) {
            Schema::table('suppliers', function (Blueprint $table) {
                $table->integer('initial_due')->nullable()->after('expense');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('initial_due');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn('initial_due');
        });
    }
};
