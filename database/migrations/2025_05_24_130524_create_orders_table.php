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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('email')->nullable();
            $table->string('whatsapp');

            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('material_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('size_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('lamination_id')->nullable()->constrained()->nullOnDelete();

            $table->integer('quantity')->default(1);
            $table->text('custom_description')->nullable(); // jika tidak upload
            $table->string('design_file')->nullable(); // upload file desain
            $table->decimal('total_price', 10, 2)->default(0);
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'batal'])->default('menunggu');
            $table->enum('payment_status', ['belum', 'menunggu_verifikasi', 'sudah'])->default('belum');
            $table->string('payment_proof')->nullable(); // jika ingin ditambahkan nanti
            $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
