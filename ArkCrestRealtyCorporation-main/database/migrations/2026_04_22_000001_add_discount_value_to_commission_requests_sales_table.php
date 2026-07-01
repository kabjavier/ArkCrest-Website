<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commission_requests_sales', function (Blueprint $table) {
            if (!Schema::hasColumn('commission_requests_sales', 'discount_value'))
                $table->decimal('discount_value', 15, 2)->nullable()->after('discount');
        });
    }

    public function down(): void
    {
        Schema::table('commission_requests_sales', function (Blueprint $table) {
            if (Schema::hasColumn('commission_requests_sales', 'discount_value'))
                $table->dropColumn('discount_value');
        });
    }
};
