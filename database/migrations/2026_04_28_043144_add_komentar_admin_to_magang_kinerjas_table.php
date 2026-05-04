<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('magang_kinerjas', function (Blueprint $table) {
            $table->text('komentar_admin')->nullable()->after('file_path');
        });
    }

    public function down(): void
    {
        Schema::table('magang_kinerjas', function (Blueprint $table) {
            $table->dropColumn('komentar_admin');
        });
    }
};