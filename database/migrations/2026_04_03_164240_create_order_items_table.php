<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel order_items sebagai detail dari pesanan (Pivot table).
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel orders dan menus
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');

            // Detail Item
            $table->integer('qty')->default(1);
            $table->integer('price')->default(0); // Harga saat dibeli (takutnya harga menu berubah nantinya)
            $table->integer('subtotal')->default(0);
            $table->text('notes')->nullable(); // Contoh: "Sedikit gula", "Tanpa es"

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};