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
        Schema::create('laminations', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // e.g., Glossy, Doff
        $table->decimal('additional_price', 10, 2)->default(0); 
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laminations');
    }
};
