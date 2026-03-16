<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
    {
        Schema::table('laporan_pkl', function (Blueprint $table) {
            // Kita pake text biar si siswa bebas ngetik link panjang/pendek
            $table->text('link_drive')->nullable()->after('file');
        });
    }

    public function down()
    {
        Schema::table('laporan_pkl', function (Blueprint $table) {
            $table->dropColumn('link_drive');
        });
    }
};
