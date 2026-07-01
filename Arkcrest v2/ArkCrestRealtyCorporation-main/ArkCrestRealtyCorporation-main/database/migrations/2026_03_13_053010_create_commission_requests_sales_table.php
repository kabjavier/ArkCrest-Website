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
        Schema::create('commission_requests_sales', function (Blueprint $table) {
            $table->id();
            $table->date('date_requested');
            $table->string('project_name');
            $table->string('property_details');
            $table->string('block_lot_number')->nullable();
            $table->string('client_name');
            $table->string('terms_of_payment');
            $table->string('agent_name');
            $table->integer('number_of_units');
            $table->decimal('price_sqm', 15, 2)->nullable();
            $table->decimal('lot_area', 15, 4)->nullable();
            $table->decimal('tcp', 15, 2)->nullable();
            $table->decimal('discount', 15, 2)->nullable();
            $table->decimal('net_tcp', 15, 2)->nullable();
            $table->decimal('commission', 15, 2)->nullable();
            $table->decimal('commission_percent', 5, 2)->nullable();
            $table->string('mode_of_payment')->nullable();
            $table->date('reservation_date')->nullable();
            $table->date('date_of_downpayment')->nullable();
            $table->date('date_released')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_requests_sales');
    }
};
