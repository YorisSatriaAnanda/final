<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel orders untuk menyimpan data transaksi.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // Informasi Transaksi
            $table->string('invoice_code')->unique();
            $table->string('customer_name')->nullable();
            
            // Data Pembayaran
            $table->integer('total_price')->default(0);
            $table->string('payment_method')->nullable(); // cash, qris, debit
            $table->integer('paid_amount')->default(0);
            $table->integer('change_amount')->default(0);
            
            // Status Pesanan
            $table->string('status')->default('pending'); // pending, paid, cancelled
            
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