<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commission_requests_sales', function (Blueprint $table) {
            if (!Schema::hasColumn('commission_requests_sales', 'developer_name'))
                $table->string('developer_name')->nullable()->after('id');
            if (!Schema::hasColumn('commission_requests_sales', 'remarks'))
                $table->text('remarks')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('commission_requests_sales', function (Blueprint $table) {
            if (Schema::hasColumn('commission_requests_sales', 'developer_name'))
                $table->dropColumn('developer_name');
            if (Schema::hasColumn('commission_requests_sales', 'remarks'))
                $table->dropColumn('remarks');
        });
    }
};
