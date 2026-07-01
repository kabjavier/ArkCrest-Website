<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('downpayment_installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commission_request_sales_id');
            $table->integer('term_number');
            $table->decimal('amount', 15, 2)->nullable();
            $table->boolean('is_paid')->default(false);
            $table->date('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('downpayment_installments');
    }
};
