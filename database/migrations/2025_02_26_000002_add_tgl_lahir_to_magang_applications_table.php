<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('magang_applications', function (Blueprint $table) {
            // Menambahkan kolom tgl_lahir yang dibutuhkan untuk verifikasi status
            if (!Schema::hasColumn('magang_applications', 'tgl_lahir')) {
                $table->date('tgl_lahir')->nullable()->after('nik');
            }
        });
    }

    public function down(): void
    {
        Schema::table('magang_applications', function (Blueprint $table) {
            if (Schema::hasColumn('magang_applications', 'tgl_lahir')) {
                $table->dropColumn('tgl_lahir');
            }
        });
    }
};