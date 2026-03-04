<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\post;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

test('registration page can be rendered', function () {
    get(route('sample.register.index'))->assertStatus(200);
});

/**
 * Test Validasi Dasar
 */
test('registration requires main fields', function () {
    post(route('sample.register.store'), [])
        ->assertSessionHasErrors([
            'statusPengajuan', 'nama', 'kontakHp', 'email', 'nik',
            'tglLahir', 'alamat', 'tglMulai', 'tglSelesai', 'tujuan', 'pernyataan'
        ]);
});

/**
 * Test Logika Bisnis (Usia & Durasi)
 */
test('registration fails if age is below 17', function () {
    $data = ['tglLahir' => now()->subYears(16)->format('Y-m-d')];
    post(route('sample.register.store'), $data)->assertSessionHasErrors(['tglLahir']);
});

test('registration fails if duration is less than 1 month', function () {
    $start = now()->addDay();
    $end = $start->copy()->addDays(20); // Hanya 20 hari

    $data = [
        'tglMulai' => $start->format('Y-m-d'),
        'tglSelesai' => $end->format('Y-m-d'),
    ];

    post(route('sample.register.store'), $data)->assertSessionHasErrors(['tglSelesai']);
});

/**
 * Test Validasi Jalur Mandiri
 */
test('mandiri registration requires specific files', function () {
    post(route('sample.register.store'), ['statusPengajuan' => 'mandiri'])
        ->assertSessionHasErrors(['suratMandiri', 'ktpMandiri', 'fotoMandiri']);
});

test('user can register via mandiri path', function () {
    Storage::fake('public');

    $data = [
        'statusPengajuan' => 'mandiri',
        'nama' => 'Budi Santoso',
        'kontakHp' => '081234567890',
        'email' => 'budi@example.com',
        'nik' => '3201010101000001',
        'tglLahir' => '2000-01-01',
        'alamat' => 'Jl. Merdeka No. 1',
        'tglMulai' => now()->addDays(7)->format('Y-m-d'),
        'tglSelesai' => now()->addDays(40)->format('Y-m-d'), // > 1 bulan
        'tujuan' => 'Magang Mandiri',
        'pendidikanAsal_m' => 'Univ Indonesia',
        'prodi_m' => 'Hukum',
        'pernyataan' => 'on',
        'suratMandiri' => UploadedFile::fake()->create('surat.pdf', 500, 'application/pdf'),
        'ktpMandiri' => UploadedFile::fake()->create('ktp.jpg', 500, 'image/jpeg'),
        'fotoMandiri' => UploadedFile::fake()->create('foto.jpg', 500, 'image/jpeg'),
    ];

    post(route('sample.register.store'), $data)
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('sample.register.index'))
        ->assertSessionHas('success');

    // Pastikan data masuk database
    $this->assertDatabaseHas('magang_applications', [
        'email' => 'budi@example.com',
        'status_pengajuan' => 'mandiri'
    ]);
});

/**
 * Test Validasi Jalur Institusi
 */
test('institusi registration requires specific fields', function () {
    post(route('sample.register.store'), ['statusPengajuan' => 'institusi'])
        ->assertSessionHasErrors([
            'institusi', 'nim', 'fakultas', 'semester',
            'suratPengantar', 'transkrip', 'fotoInstitusi'
        ]);
});

test('user can register via institusi path', function () {
    Storage::fake('public');

    $data = [
        'statusPengajuan' => 'institusi',
        'nama' => 'Siti Aminah',
        'kontakHp' => '081298765432',
        'email' => 'siti@example.com',
        'nik' => '3201010101000002',
        'tglLahir' => '2002-05-05',
        'alamat' => 'Jl. Sudirman',
        'tglMulai' => now()->addDays(7)->format('Y-m-d'),
        'tglSelesai' => now()->addDays(60)->format('Y-m-d'),
        'tujuan' => 'PKL Kampus',
        'institusi' => 'UGM',
        'nim' => '12345/HK',
        'fakultas' => 'Hukum',
        'semester' => '6',
        'pembimbing' => 'Dr. Dosen',
        'kontakPembimbing' => '08111',
        'jumlahPeserta' => '1',
        'pernyataan' => 'on',
        'suratPengantar' => UploadedFile::fake()->create('pengantar.pdf', 500, 'application/pdf'),
        'transkrip' => UploadedFile::fake()->create('transkrip.pdf', 500, 'application/pdf'),
        'fotoInstitusi' => UploadedFile::fake()->create('foto.jpg', 500, 'image/jpeg'),
        'proposal' => UploadedFile::fake()->create('proposal.pdf', 500, 'application/pdf'),
    ];

    post(route('sample.register.store'), $data)
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('sample.register.index'));

    $this->assertDatabaseHas('magang_applications', [
        'email' => 'siti@example.com',
        'status_pengajuan' => 'institusi',
        'nim' => '12345/HK'
    ]);
});