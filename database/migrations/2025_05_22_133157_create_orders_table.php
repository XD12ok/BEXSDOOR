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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_code')->unique();
            $table->decimal('total_price', 12, 2);
            $table->enum('status', [
                'pending',      // Belum dibayar
                'paid',         // Sudah bayar
                'processing',   // Sedang diproses
                'shipped',      // Sudah dikirim
                'delivered',    // Sampai ke pembeli
                'success',      // sudah berhasil
                'cancelled',    // Dibatalkan
                'failed'        // Gagal
            ])->default('pending');
            $table->string('payment_type')->nullable();
            $table->string('snap_token')->nullable(); // untuk Midtrans
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
