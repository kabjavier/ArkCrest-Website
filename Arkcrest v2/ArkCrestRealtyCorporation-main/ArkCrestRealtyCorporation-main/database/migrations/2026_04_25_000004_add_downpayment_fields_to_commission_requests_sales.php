<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $cols = [
            'downpayment_amount'      => 'DECIMAL(15,2) NULL',
            'downpayment_terms'       => 'INT NULL',
            'downpayment_per_term'    => 'DECIMAL(15,2) NULL',
        ];
        foreach ($cols as $col => $type) {
            try { DB::statement("ALTER TABLE commission_requests_sales ADD COLUMN {$col} {$type}"); }
            catch (\Exception $e) {}
        }
    }

    public function down(): void {}
};
