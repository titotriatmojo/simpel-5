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
            // Pake text supaya kalau siswanya ngetik link yang sangat panjang gak error
            $table->text('link_drive')->nullable()->after('file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_pkl', function (Blueprint $table) {
            //
        });
    }
};
