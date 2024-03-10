<?php

use App\Enums\PaymentPaidBy;
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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('ulid')->unique()->index();
            $table->foreignId('account_id')->constrained();
            $table->integer('amount');
            $table->string('type'); // Credit or Debit
            $table->string('paid_by')->default(PaymentPaidBy::CASH->value); // Cash, Cheque, Bank, Deposit
            $table->string('reference')->nullable();
            $table->text('details')->nullable();
            $table->morphs('paymentable');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
