<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('magang_applications', function (Blueprint $table) {
            $table->id();
            $table->string('status_pengajuan');
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->string('nama');
            $table->date('tgl_lahir')->nullable();
            $table->string('no_hp');
            $table->string('email');
            $table->string('nik', 255)->nullable();
            $table->text('alamat');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai');
            $table->json('bidang')->nullable();
            $table->text('tujuan');

            // Mandiri fields
            $table->string('pendidikan_asal')->nullable();
            $table->string('prodi')->nullable();

            // Institusi fields
            $table->string('institusi')->nullable();
            $table->string('nim')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('semester')->nullable();
            $table->string('pembimbing')->nullable();
            $table->string('kontak_pembimbing')->nullable();
            $table->string('jumlah_peserta')->nullable();

            // File paths
            $table->string('surat_permohonan_path')->nullable();
            $table->string('ktp_path')->nullable();
            $table->string('foto_path')->nullable();
            $table->string('surat_pengantar_path')->nullable();
            $table->string('transkrip_path')->nullable();
            $table->string('proposal_path')->nullable();
            $table->string('laporan_akhir_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('magang_applications');
    }
};