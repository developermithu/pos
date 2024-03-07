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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->foreignId('unit_id')->constrained();
            $table->foreignId('purchase_unit_id')->nullable()->constrained('units');
            $table->foreignId('sale_unit_id')->nullable()->constrained('units');

            $table->string('name');
            $table->string('sku')->unique();
            $table->integer('qty')->nullable();
            $table->integer('alert_qty')->nullable();
            $table->integer('cost');
            $table->integer('price');
            $table->string('type'); // standard or service
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
