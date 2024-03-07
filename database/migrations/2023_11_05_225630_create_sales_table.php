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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->string('invoice_no');
            $table->integer('subtotal');
            $table->integer('tax')->default(0)->nullable();
            $table->integer('total');
            $table->integer('paid_amount')->default(0)->nullable();
            $table->string('status')->comment('ordered', 'pending', 'delivered');
            $table->string('payment_status')->comment('pending', 'due', 'partial', 'paid');
            $table->text('details')->nullable();
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
