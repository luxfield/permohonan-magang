<?php

namespace Tests\Feature;

use App\Http\Controllers\MagangController;
use App\Models\MagangApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MagangApplicationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Kita definisikan route sementara agar test ini spesifik menargetkan MagangController
        // terlepas dari konfigurasi routes/web.php saat ini.
        Route::post('/test/magang/store', [MagangController::class, 'store'])->name('test.magang.store');
    }

    public function test_pengajuan_magang_mandiri_berhasil_disimpan()
    {
        Storage::fake('public');

        // Mock file uploads
        $fileSurat = UploadedFile::fake()->create('surat.pdf', 1000, 'application/pdf');
        $fileKtp = UploadedFile::fake()->create('ktp.jpg', 1000, 'image/jpeg');
        $fileFoto = UploadedFile::fake()->create('foto.jpg', 1000, 'image/jpeg');

        $response = $this->post(route('test.magang.store'), [
            'statusPengajuan' => 'mandiri',
            'nama' => 'Budi Santoso',
            'kontakHp' => '081234567890',
            'email' => 'budi@example.com',
            'nik' => '1234567890123456',
            'tglLahir' => '2000-01-01',
            'alamat' => 'Jl. Merdeka No. 1',
            'tglMulai' => now()->addDay()->format('Y-m-d'),
            'tglSelesai' => now()->addMonths(2)->format('Y-m-d'),
            'bidang' => ['Pidum', 'Pidsus'],
            'tujuan' => 'Mencari pengalaman',
            'pernyataan' => 'on',
            
            // Field Khusus Mandiri
            'pendidikanAsal_m' => 'Universitas Indonesia',
            'prodi_m' => 'Hukum',
            'suratMandiri' => $fileSurat,
            'ktpMandiri' => $fileKtp,
            'fotoMandiri' => $fileFoto,
        ]);

        // Assert Redirect & Session Success
        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Assert Database
        $this->assertDatabaseHas('magang_applications', [
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'status_pengajuan' => 'mandiri',
            'nik' => '1234567890123456',
            'pendidikan_asal' => 'Universitas Indonesia',
        ]);

        // Assert File Storage
        Storage::disk('public')->assertExists('uploads/surat/' . $fileSurat->hashName());
        Storage::disk('public')->assertExists('uploads/ktp/' . $fileKtp->hashName());
        Storage::disk('public')->assertExists('uploads/foto/' . $fileFoto->hashName());
    }

    public function test_pengajuan_magang_institusi_berhasil_disimpan()
    {
        Storage::fake('public');

        $fileSurat = UploadedFile::fake()->create('surat.pdf', 1000, 'application/pdf');
        $fileTranskrip = UploadedFile::fake()->create('transkrip.pdf', 1000, 'application/pdf');
        $fileFoto = UploadedFile::fake()->create('foto.jpg', 1000, 'image/jpeg');

        $response = $this->post(route('test.magang.store'), [
            'statusPengajuan' => 'institusi',
            'nama' => 'Siti Aminah',
            'kontakHp' => '089876543210',
            'email' => 'siti@example.com',
            'nik' => '6543210987654321',
            'tglLahir' => '2000-05-05',
            'alamat' => 'Jl. Asia Afrika',
            'tglMulai' => now()->addDay()->format('Y-m-d'),
            'tglSelesai' => now()->addMonths(2)->format('Y-m-d'),
            'bidang' => ['Datun'],
            'tujuan' => 'PKL Kampus',
            'pernyataan' => 'on',

            // Field Khusus Institusi
            'institusi' => 'UNPAD',
            'nim' => '12345678',
            'fakultas' => 'Hukum',
            'semester' => '6',
            'pembimbing' => 'Dr. Dosen',
            'kontakPembimbing' => '08111111111',
            'jumlahPeserta' => '1',
            'suratPengantar' => $fileSurat,
            'transkrip' => $fileTranskrip,
            'fotoInstitusi' => $fileFoto,
        ]);

        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('magang_applications', [
            'nama' => 'Siti Aminah',
            'status_pengajuan' => 'institusi',
            'institusi' => 'UNPAD',
            'nim' => '12345678',
        ]);
    }

    public function test_validasi_gagal_jika_data_tidak_lengkap()
    {
        $response = $this->post(route('test.magang.store'), []);

        $response->assertSessionHasErrors([
            'statusPengajuan', 'nama', 'email', 'nik', 'kontakHp', 'tglLahir'
        ]);
    }
}