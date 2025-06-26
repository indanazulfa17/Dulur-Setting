<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('material_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->decimal('additional_price', 10, 2)->default(0); // Harga tambahan khusus produk ini
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_product');
    }
};
