<?php

namespace Database\Seeders;

use App\Models\MagangApplication;
use Illuminate\Database\Seeder;

class MagangApplicationSeeder extends Seeder
{
    public function run(): void
    {
        // Contoh 1: Pendaftar Jalur Mandiri
        MagangApplication::create([
            'status_pengajuan' => 'mandiri',
            'nama' => 'Budi Santoso',
            'no_hp' => '081234567890',
            'email' => 'budi.santoso@example.com',
            'nik' => '3171234567890001',
            'alamat' => 'Jl. Fatmawati No. 10, Jakarta Selatan',
            'tgl_mulai' => now()->addDays(7),
            'tgl_selesai' => now()->addMonths(3),
            'tujuan' => 'Mencari pengalaman kerja dan memenuhi tugas akhir kuliah.',
            // 'bidang' => ['Pidum'], // Dihapus sesuai request sebelumnya
            
            // Data Khusus Mandiri
            'pendidikan_asal' => 'Universitas Indonesia',
            'prodi' => 'Ilmu Hukum',
            
            // Dummy paths (File tidak benar-benar ada, hanya string untuk database)
            'surat_permohonan_path' => 'uploads/dummy/surat.pdf',
            'ktp_path' => 'uploads/dummy/ktp.jpg',
            'foto_path' => 'uploads/dummy/foto.jpg',
        ]);

        // Contoh 2: Pendaftar Jalur Institusi
        MagangApplication::create([
            'status_pengajuan' => 'institusi',
            'nama' => 'Siti Aminah',
            'no_hp' => '081987654321',
            'email' => 'siti.aminah@example.com',
            'nik' => '3273123456780002',
            'alamat' => 'Jl. Dago No. 55, Bandung',
            'tgl_mulai' => now()->addDays(14),
            'tgl_selesai' => now()->addMonths(2),
            'tujuan' => 'Praktik Kerja Lapangan (PKL) semester 6.',
            // 'bidang' => ['Datun', 'Pidsus'], // Dihapus sesuai request sebelumnya

            // Data Khusus Institusi
            'institusi' => 'Universitas Padjadjaran',
            'nim' => '110110190001',
            'fakultas' => 'Hukum',
            'semester' => '6',
            'pembimbing' => 'Dr. Ahmad Hidayat',
            'kontak_pembimbing' => '081333444555',
            'jumlah_peserta' => '1',

            // Dummy paths
            'surat_pengantar_path' => 'uploads/dummy/pengantar.pdf',
            'transkrip_path' => 'uploads/dummy/transkrip.pdf',
            'foto_path' => 'uploads/dummy/foto_siti.jpg',
        ]);

        // Tambahkan data dummy lainnya jika perlu
        MagangApplication::factory()->count(10)->create();
    }
}
