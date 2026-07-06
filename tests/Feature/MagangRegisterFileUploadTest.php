<?php

use Illuminate\Http\UploadedFile;
use function Pest\Laravel\post;

it('validates suratMandiri size is not larger than 10MB', function () {
    $file = UploadedFile::fake()->create('surat.pdf', 10241); // 10241 KB = >10MB

    $response = post(route('sample.register.store'), [
        'statusPengajuan' => 'mandiri',
        'nama' => 'Test Name',
        'kontakHp' => '081234567890',
        'email' => 'test@example.com',
        'nik' => '1234567890123456',
        'tglLahir' => '2000-01-01',
        'alamat' => 'Test Address',
        'tglMulai' => now()->addDay()->toDateString(),
        'tglSelesai' => now()->addMonths(2)->toDateString(),
        'tujuan' => 'Test Tujuan',
        'pernyataan' => 'on',
        'suratMandiri' => $file,
    ]);

    $response->assertSessionHasErrors(['suratMandiri' => 'Ukuran file Surat Permohonan maksimal 10MB.']);
});

it('validates ktpMandiri and fotoMandiri sizes are not larger than 10MB', function () {
    $ktp = UploadedFile::fake()->create('ktp.jpg', 10241);
    $foto = UploadedFile::fake()->create('foto.jpg', 10241);

    $response = post(route('sample.register.store'), [
        'statusPengajuan' => 'mandiri',
        'nama' => 'Test Name',
        'kontakHp' => '081234567890',
        'email' => 'test@example.com',
        'nik' => '1234567890123456',
        'tglLahir' => '2000-01-01',
        'alamat' => 'Test Address',
        'tglMulai' => now()->addDay()->toDateString(),
        'tglSelesai' => now()->addMonths(2)->toDateString(),
        'tujuan' => 'Test Tujuan',
        'pernyataan' => 'on',
        'ktpMandiri' => $ktp,
        'fotoMandiri' => $foto,
    ]);

    $response->assertSessionHasErrors([
        'ktpMandiri' => 'Ukuran file KTP maksimal 10MB.',
        'fotoMandiri' => 'Ukuran file Pas Foto maksimal 10MB.',
    ]);
});

it('validates institusi file uploads sizes are not larger than 10MB', function () {
    $suratPengantar = UploadedFile::fake()->create('surat_pengantar.pdf', 10241);
    $proposal = UploadedFile::fake()->create('proposal.pdf', 10241);

    $response = post(route('sample.register.store'), [
        'statusPengajuan' => 'institusi',
        'tglMulai' => now()->addDay()->toDateString(),
        'tglSelesai' => now()->addMonths(2)->toDateString(),
        'tujuan' => 'Test Tujuan',
        'pernyataan' => 'on',
        'institusi' => 'Test Institusi',
        'fakultas' => 'Test Fakultas',
        'semester' => '5',
        'pembimbing' => 'Test Pembimbing',
        'kontakPembimbing' => '081234567890',
        'jumlahPeserta' => '2-5',
        'suratPengantar' => $suratPengantar,
        'proposal' => $proposal,
    ]);

    $response->assertSessionHasErrors([
        'suratPengantar' => 'Ukuran file Surat Pengantar maksimal 10MB.',
        'proposal' => 'Ukuran file Proposal maksimal 10MB.',
    ]);
});
