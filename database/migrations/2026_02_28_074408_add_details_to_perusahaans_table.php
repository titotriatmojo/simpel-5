<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perusahaan', function (Blueprint $table) {
            // Menambah kolom yang kurang
            $table->string('bidang_usaha')->after('nama')->nullable();
            $table->string('pembimbing_lapangan')->after('no_hp')->nullable();
            $table->string('email')->after('pembimbing_lapangan')->nullable();
            $table->text('koordinat_lokasi')->after('email')->nullable();
            $table->integer('kuota')->after('koordinat_lokasi')->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('perusahaan', function (Blueprint $table) {
            $table->dropColumn(['bidang_usaha', 'pembimbing_lapangan', 'email', 'koordinat_lokasi', 'kuota']);
        });
    }
};