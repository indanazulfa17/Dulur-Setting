<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Update enum status pada tabel orders.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE orders 
            MODIFY status ENUM('draft', 'menunggu', 'diproses', 'selesai', 'dibatalkan') 
            DEFAULT 'draft'
        ");
    }

    /**
     * Kembalikan enum status ke kondisi sebelumnya jika rollback.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE orders 
            MODIFY status ENUM('pending', 'draft', 'completed', 'diproses', 'selesai', 'dibatalkan') 
            DEFAULT 'draft'
        ");
    }
};
