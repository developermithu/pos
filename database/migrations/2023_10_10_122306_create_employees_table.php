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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('father_name');
            $table->string('address')->nullable();
            $table->string('phone_number')->unique();
            $table->enum('gender', ['male', 'female']);
            $table->integer('basic_salary');
            $table->integer('old_basic_salary')->nullable();
            $table->date('salary_updated_at')->nullable();
            $table->date('joined_at');
            $table->boolean('is_active');
            $table->integer('balance')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
