<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('product_images', function (Blueprint $table) {
        $table->string('image_path')->nullable()->change();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    Schema::table('product_images', function (Blueprint $table) {
        $table->string('image_path')->nullable(false)->change();
    });
    }
};
