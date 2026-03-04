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
            // Menambahkan status: pending (default), diterima, ditolak
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending')->after('status_pengajuan');
            // Menambahkan catatan dari admin
            $table->text('catatan_admin')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magang_applications', function (Blueprint $table) {
            $table->dropColumn(['status', 'catatan_admin']);
        });
    }
};