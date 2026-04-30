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
    Schema::create('data_trainings', function (Blueprint $table) {
        $table->id();
        $table->string('nama')->nullable(); // TAMBAHKAN INI
        $table->double('nilai_pkl');
        $table->double('nilai_sidang');
        $table->double('nilai_total');
        $table->string('label'); // Siap / Tidak Siap
        $table->timestamps();
    });
}};