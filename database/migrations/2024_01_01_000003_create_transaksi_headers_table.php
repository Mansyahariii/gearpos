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
        Schema::create('transaksi_headers', function (Blueprint $table) {
            $table->id('transaksi_id');
            $table->dateTime('tanggal');
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->enum('metode_pembayaran', ['tunai', 'transfer', 'qris', 'lainnya'])->default('tunai');
            $table->enum('status', ['selesai', 'pending', 'batal'])->default('pending');
            $table->unsignedBigInteger('kasir_id');
            
            $table->foreign('kasir_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_headers');
    }
};
