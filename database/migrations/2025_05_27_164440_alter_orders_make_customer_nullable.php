<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOrdersMakeCustomerNullable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->change();
            $table->string('whatsapp')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hati-hati: rollback ini akan gagal kalau ada nilai NULL di kolom-kolom ini
            $table->string('customer_name')->nullable(false)->change();
            $table->string('whatsapp')->nullable(false)->change();
        });
    }
}

