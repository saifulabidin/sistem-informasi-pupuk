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
        Schema::create('pembelian_pupuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petani_id')->constrained('petani')->onDelete('cascade');
            $table->foreignId('pupuk_id')->constrained('pupuks')->onDelete('cascade');
            $table->foreignId('alokasi_pupuk_id')->nullable()->constrained('alokasi_pupuks')->nullOnDelete();
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('total_harga', 12, 2);
            $table->date('tanggal_pembelian');
            $table->string('metode_pembayaran')->default('tunai'); // tunai, transfer
            $table->string('status_pembayaran')->default('lunas'); // lunas, hutang
            $table->text('keterangan')->nullable();
            $table->string('no_bukti')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_pupuks');
    }
};
