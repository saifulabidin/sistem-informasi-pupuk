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
        Schema::create('alokasi_pupuks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelompok_tani_id');
            $table->unsignedBigInteger('pupuk_id');
            $table->integer('jumlah_alokasi');
            $table->string('status')->default('belum_diambil'); // belum_diambil, sebagian, selesai
            $table->integer('jumlah_diambil')->default(0);
            $table->date('tanggal_alokasi');
            $table->string('periode')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alokasi_pupuks');
    }
};
