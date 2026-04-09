<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom stock dan is_available ke tabel menus.
     */
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Menambahkan kolom stock setelah kolom price
            $table->integer('stock')->default(100)->after('price');
            
            // Menambahkan kolom status ketersediaan setelah is_best_seller
            $table->boolean('is_available')->default(true)->after('is_best_seller');
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus kembali kolom jika migrasi di-rollback.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['stock', 'is_available']);
        });
    }
};