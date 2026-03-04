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
        Schema::table('magang_applications', function (Blueprint $table) {
            if (!Schema::hasColumn('magang_applications', 'tgl_lahir')) {
                $table->date('tgl_lahir')->nullable()->after('nama');
            }
            if (!Schema::hasColumn('magang_applications', 'laporan_akhir_path')) {
                $table->string('laporan_akhir_path')->nullable()->after('catatan_admin');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magang_applications', function (Blueprint $table) {
            if (Schema::hasColumn('magang_applications', 'tgl_lahir')) {
                $table->dropColumn('tgl_lahir');
            }
            if (Schema::hasColumn('magang_applications', 'laporan_akhir_path')) {
                $table->dropColumn('laporan_akhir_path');
            }
        });
    }
};