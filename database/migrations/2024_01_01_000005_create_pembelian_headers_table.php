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
        Schema::create('pembelian_headers', function (Blueprint $table) {
            $table->id('pembelian_id');
            $table->dateTime('tanggal');
            $table->decimal('total', 12, 2)->default(0);
            $table->unsignedBigInteger('user_id');
            $table->enum('status', ['selesai', 'pending'])->default('pending');
            
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_headers');
    }
};
