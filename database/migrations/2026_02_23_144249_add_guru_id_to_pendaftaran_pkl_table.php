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
    Schema::table('pendaftaran_pkl', function (Blueprint $table) {
        // Tambahin kolom guru_id setelah perusahaan_id
        $table->unsignedBigInteger('guru_id')->after('perusahaan_id')->nullable();
        
        // Opsional: Tambah foreign key biar aman
        $table->foreign('guru_id')->references('id')->on('guru')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('pendaftaran_pkl', function (Blueprint $table) {
        $table->dropForeign(['guru_id']);
        $table->dropColumn('guru_id');
    });
}
};