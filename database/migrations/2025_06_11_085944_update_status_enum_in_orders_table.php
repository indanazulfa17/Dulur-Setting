<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // ⬅️ Tambahkan ini

class UpdateStatusEnumInOrdersTable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE orders MODIFY status ENUM('draft', 'diproses', 'selesai') DEFAULT 'draft'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE orders MODIFY status ENUM('draft', 'proses', 'selesai') DEFAULT 'draft'");
    }
}
