<?php

use App\Models\MagangApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

test('status page is accessible', function () {
    get(route('status.index'))
        ->assertOk()
        ->assertViewIs('status.index');
});

test('check status validation requires identifier and date of birth', function () {
    post(route('status.check'), [])
        ->assertSessionHasErrors(['identifier', 'tgl_lahir']);
});

test('check status returns error when application not found', function () {
    post(route('status.check'), [
        'identifier' => '1234567890123456',
        'tgl_lahir' => '2000-01-01',
    ])
    ->assertSessionHas('error', 'Data tidak ditemukan. Pastikan NIK/NIM dan Tanggal Lahir sesuai.');
});

test('check status finds application by nik and date of birth', function () {
    // Arrange: Buat data dummy
    $app = MagangApplication::create([
        'status_pengajuan' => 'mandiri',
        'nama' => 'John Doe',
        'no_hp' => '08123456789',
        'email' => 'john@example.com',
        'nik' => '1234567890123456',
        'tgl_lahir' => '2000-01-01',
        'alamat' => 'Jl. Test',
        'tgl_mulai' => now()->addDays(1),
        'tgl_selesai' => now()->addDays(32),
        'tujuan' => 'Magang',
        'status' => 'pending'
    ]);

    // Act & Assert
    post(route('status.check'), [
        'identifier' => '1234567890123456',
        'tgl_lahir' => '2000-01-01',
    ])
    ->assertOk()
    ->assertViewIs('status.show')
    ->assertViewHas('application', function ($viewApp) use ($app) {
        return $viewApp->id === $app->id;
    });
});

test('check status finds application by nim and date of birth', function () {
    // Arrange
    $app = MagangApplication::create([
        'status_pengajuan' => 'institusi',
        'nama' => 'Jane Doe',
        'no_hp' => '08987654321',
        'email' => 'jane@example.com',
        'nik' => '9876543210987654',
        'nim' => 'MHS123',
        'tgl_lahir' => '2001-05-05',
        'alamat' => 'Jl. Kampus',
        'tgl_mulai' => now()->addDays(1),
        'tgl_selesai' => now()->addDays(32),
        'tujuan' => 'PKL',
        'status' => 'pending'
    ]);

    // Act & Assert
    post(route('status.check'), [
        'identifier' => 'MHS123',
        'tgl_lahir' => '2001-05-05',
    ])
    ->assertOk()
    ->assertViewIs('status.show');
});

test('upload report fails if status is not diterima', function () {
    $app = MagangApplication::create([
        'status_pengajuan' => 'mandiri',
        'nama' => 'John Doe',
        'no_hp' => '08123456789',
        'email' => 'john@example.com',
        'nik' => '1234567890123456',
        'tgl_lahir' => '2000-01-01',
        'alamat' => 'Jl. Test',
        'tgl_mulai' => now()->addDays(1),
        'tgl_selesai' => now()->addDays(32),
        'tujuan' => 'Magang',
        'status' => 'pending' // Status bukan diterima
    ]);

    Storage::fake('public');
    $file = UploadedFile::fake()->create('laporan.pdf', 1024, 'application/pdf');

    post(route('status.upload', $app->id), ['laporan_akhir' => $file])
        ->assertForbidden(); // Harusnya 403
});

test('upload report fails if too early', function () {
    $app = MagangApplication::create([
        'status_pengajuan' => 'mandiri',
        'nama' => 'John Doe',
        'no_hp' => '08123456789',
        'email' => 'john@example.com',
        'nik' => '1234567890123456',
        'tgl_lahir' => '2000-01-01',
        'alamat' => 'Jl. Test',
        'tgl_mulai' => now()->addDays(1),
        'tgl_selesai' => now()->addDays(30), // Masih lama (30 hari lagi), belum H-7
        'tujuan' => 'Magang',
        'status' => 'diterima'
    ]);

    Storage::fake('public');
    $file = UploadedFile::fake()->create('laporan.pdf', 1024, 'application/pdf');

    post(route('status.upload', $app->id), ['laporan_akhir' => $file])
        ->assertSessionHas('error', 'Maaf, periode upload laporan belum dibuka.');
});

test('upload report succeeds if status is diterima', function () {
    $app = MagangApplication::create([
        'status_pengajuan' => 'mandiri',
        'nama' => 'John Doe',
        'no_hp' => '08123456789',
        'email' => 'john@example.com',
        'nik' => '1234567890123456',
        'tgl_lahir' => '2000-01-01',
        'alamat' => 'Jl. Test',
        'tgl_mulai' => now()->addDays(1),
        'tgl_selesai' => now()->addDays(5), // Sudah masuk periode H-7 (karena 5 < 7)
        'tujuan' => 'Magang',
        'status' => 'diterima' // Status Diterima
    ]);

    Storage::fake('public');
    $file = UploadedFile::fake()->create('laporan.pdf', 1024, 'application/pdf');

    post(route('status.upload', $app->id), ['laporan_akhir' => $file])
        ->assertRedirect()
        ->assertSessionHas('success');

    // Verifikasi file tersimpan
    $app->refresh();
    expect($app->laporan_akhir_path)->not->toBeNull();
    Storage::disk('public')->assertExists($app->laporan_akhir_path);
});