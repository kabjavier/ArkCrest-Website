<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departmental_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('control_number')->unique()->nullable();
            $table->string('requestor_name')->nullable();
            $table->string('department')->nullable();
            $table->string('category')->nullable();
            $table->date('date_requested')->nullable();
            $table->decimal('requested_amount', 15, 2)->nullable();
            $table->string('status')->default('NOT YET LIQUIDATED');
            $table->date('date_released')->nullable();
            $table->decimal('total_expenses', 15, 2)->nullable();
            $table->decimal('amount_returned', 15, 2)->nullable();
            $table->date('date_of_amount_returned')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departmental_expenses');
    }
};
