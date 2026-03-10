<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $blueprint) {
            // Menambahkan kolom setelah email agar rapi di database
            $blueprint->string('no_hp_ortu')->nullable()->after('email');
            $blueprint->text('alamat')->nullable()->after('no_hp_ortu');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $blueprint) {
            $blueprint->dropColumn(['no_hp_ortu', 'alamat']);
        });
    }
};