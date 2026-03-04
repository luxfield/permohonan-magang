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
            $table->json('bidang')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('magang_applications', function (Blueprint $table) {
            // Kembalikan ke tidak nullable jika di-rollback (pastikan data tidak ada yang null)
            $table->json('bidang')->nullable(false)->change();
        });
    }
};