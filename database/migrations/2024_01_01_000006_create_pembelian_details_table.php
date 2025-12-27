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
        Schema::create('pembelian_details', function (Blueprint $table) {
            $table->id('detail_id');
            $table->unsignedBigInteger('pembelian_id');
            $table->unsignedBigInteger('barang_id');
            $table->integer('jumlah')->default(1);
            $table->decimal('harga_beli', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            
            $table->foreign('pembelian_id')->references('pembelian_id')->on('pembelian_headers')->onDelete('cascade');
            $table->foreign('barang_id')->references('barang_id')->on('barangs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_details');
    }
};
