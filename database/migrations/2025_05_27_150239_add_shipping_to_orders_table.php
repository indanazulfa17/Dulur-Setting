<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('shipping_method', ['ambil', 'kirim'])->default('ambil')->after('custom_description');
            $table->text('shipping_address')->nullable()->after('shipping_method');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('shipping_method');
            $table->dropColumn('shipping_address');
        });
    }

};
