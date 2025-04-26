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
        Schema::table('alokasi_pupuks', function (Blueprint $table) {
            $table->foreign('kelompok_tani_id')->references('id')->on('kelompok_tani')->onDelete('cascade');
            $table->foreign('pupuk_id')->references('id')->on('pupuks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alokasi_pupuks', function (Blueprint $table) {
            $table->dropForeign(['kelompok_tani_id']);
            $table->dropForeign(['pupuk_id']);
        });
    }
};
