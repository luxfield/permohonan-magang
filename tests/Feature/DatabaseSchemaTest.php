<?php

use Illuminate\Support\Facades\Schema;

test('tabel magang_applications memiliki struktur kolom yang benar', function () {
    // Jalankan migrasi fresh untuk memastikan kita mengetes struktur terbaru
    $this->artisan('migrate:fresh');

    // 1. Pastikan tabel terbentuk
    expect(Schema::hasTable('magang_applications'))->toBeTrue();

    // 2. Daftar kolom yang wajib ada sesuai migration yang baru dirapikan
    $expectedColumns = [
        'id',
        'status_pengajuan',
        'status',          // Enum: pending, diterima, ditolak
        'catatan_admin',
        'nama',
        'tgl_lahir',
        'no_hp',
        'email',
        'nik',
        'alamat',
        'tgl_mulai',
        'tgl_selesai',
        'bidang',          // JSON
        'tujuan',
        
        // Field Mandiri
        'pendidikan_asal',
        'prodi',
        
        // Field Institusi
        'institusi',
        'nim',
        'fakultas',
        'semester',
        'pembimbing',
        'kontak_pembimbing',
        'jumlah_peserta',
        
        // File Paths
        'surat_permohonan_path',
        'ktp_path',
        'foto_path',
        'surat_pengantar_path',
        'transkrip_path',
        'proposal_path',
        'laporan_akhir_path',
    ];

    foreach ($expectedColumns as $column) {
        expect(Schema::hasColumn('magang_applications', $column))
            ->toBeTrue("Kolom '{$column}' gagal dibuat atau hilang dari tabel magang_applications.");
    }
});