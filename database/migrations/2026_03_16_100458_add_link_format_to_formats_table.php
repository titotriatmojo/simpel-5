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
    Schema::table('format_laporan', function (Blueprint $table) {
        // Kita buat nullable supaya file upload tetep opsional atau sebaliknya
        $table->string('link_format')->nullable()->after('file');
    });
}

public function down()
{
    Schema::table('format_laporan', function (Blueprint $table) {
        $table->dropColumn('link_format');
    });
}
};
