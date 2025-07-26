<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateStatusEnumAddDibatalkanInOrdersTable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE orders MODIFY status ENUM('pending', 'draft', 'completed', 'diproses', 'selesai', 'dibatalkan') DEFAULT 'pending'");
    }

    public function down()
    {
        // Balik ke kondisi sebelumnya jika rollback
        DB::statement("ALTER TABLE orders MODIFY status ENUM('pending', 'draft', 'completed') DEFAULT 'pending'");
    }
}
