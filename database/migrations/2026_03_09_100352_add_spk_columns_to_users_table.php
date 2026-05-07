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
    Schema::table('users', function (Blueprint $table) {
        // Kolom untuk menghubungkan siswa ke guru
        if (!Schema::hasColumn('users', 'guru_id')) {
            $table->foreignId('guru_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
        }

        // Kolom tambahan untuk parameter KNN 
        $table->decimal('nilai_pkl', 5, 2)->nullable()->after('password');
        $table->decimal('nilai_sidang', 5, 2)->nullable()->after('nilai_pkl');
        
        // Kolom untuk menyimpan hasil akhir KNN
        $table->string('hasil_prediksi')->nullable()->after('nilai_sidang');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['guru_id']);
        $table->dropColumn(['guru_id', 'nilai_pkl', 'nilai_sidang', 'hasil_prediksi']);
    });
}
};  