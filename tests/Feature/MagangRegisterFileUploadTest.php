<?php

use Illuminate\Http\UploadedFile;

use function Pest\Laravel\post;

it('validates suratMandiri size is not larger than 5MB', function () {
    $file = UploadedFile::fake()->create('surat.pdf', 5121); // 5121 KB = >5MB

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

    $response->assertSessionHasErrors(['suratMandiri' => 'Ukuran file Surat Permohonan maksimal 5MB.']);
});

it('validates ktpMandiri and fotoMandiri sizes are not larger than 5MB', function () {
    $ktp = UploadedFile::fake()->create('ktp.jpg', 5121);
    $foto = UploadedFile::fake()->create('foto.jpg', 5121);

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
        'ktpMandiri' => 'Ukuran file KTP maksimal 5MB.',
        'fotoMandiri' => 'Ukuran file Pas Foto maksimal 5MB.',
    ]);
});

it('validates institusi file uploads sizes are not larger than 5MB', function () {
    $suratPengantar = UploadedFile::fake()->create('surat_pengantar.pdf', 5121);
    $proposal = UploadedFile::fake()->create('proposal.pdf', 5121);

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
        'suratPengantar' => 'Ukuran file Surat Pengantar maksimal 5MB.',
        'proposal' => 'Ukuran file Proposal maksimal 5MB.',
    ]);
});

it('validates buktiSurvey size is not larger than 5MB', function () {
    $file = UploadedFile::fake()->create('survey.png', 5121); // 5121 KB = >5MB

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
        'buktiSurvey' => $file,
    ]);

    $response->assertSessionHasErrors(['buktiSurvey' => 'Ukuran file bukti survey maksimal 5MB.']);
});
