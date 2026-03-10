<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alamat');
            $table->string('no_hp')->nullable();
            // --- TAMBAHKAN DUA BARIS INI ---
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved'); 
        // Note: Default 'approved' supaya data inputan Admin lama nggak error, 
        // tapi di Controller Siswa kita paksa 'pending'.
        
        $table->foreignId('siswa_id')->nullable()->constrained('siswa')->onDelete('set null');
        // ------------------------------

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaans');
    }
};