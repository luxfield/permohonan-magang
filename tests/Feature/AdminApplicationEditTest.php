<?php

use App\Models\MagangApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\put;

uses(RefreshDatabase::class);

test('guest cannot update application details', function () {
    $application = MagangApplication::factory()->create();

    put(route('admin.update_details', $application->id), [])
        ->assertRedirect(route('login'));
});

test('admin can update mandiri application details', function () {
    $user = User::factory()->create();
    $application = MagangApplication::factory()->create([
        'status_pengajuan' => 'mandiri',
        'nama' => 'Pendaftar Asli',
        'nik' => '1234567890123456',
        'email' => 'asli@example.com',
        'no_hp' => '081234567890',
        'tgl_lahir' => '2000-01-01',
        'alamat' => 'Alamat Asli',
        'tgl_mulai' => '2026-08-01',
        'tgl_selesai' => '2026-09-01',
    ]);

    actingAs($user)
        ->put(route('admin.update_details', $application->id), [
            'nama' => 'Pendaftar Baru',
            'nik' => '9876543210987654',
            'email' => 'baru@example.com',
            'no_hp' => '089876543210',
            'tgl_lahir' => '2002-02-02',
            'alamat' => 'Alamat Baru',
            'tgl_mulai' => '2026-08-05',
            'tgl_selesai' => '2026-09-10',
            'pendidikan_asal' => 'Kampus Baru',
            'prodi' => 'Informatika',
        ])
        ->assertRedirect(route('admin.show', $application->id))
        ->assertSessionHas('success', 'Data utama pemohon berhasil diperbarui.');

    $this->assertDatabaseHas('magang_applications', [
        'id' => $application->id,
        'nama' => 'Pendaftar Baru',
        'email' => 'baru@example.com',
        'no_hp' => '089876543210',
        'alamat' => 'Alamat Baru',
        'pendidikan_asal' => 'Kampus Baru',
    ]);
});

test('admin can update institusi application details', function () {
    $user = User::factory()->create();
    $application = MagangApplication::factory()->create([
        'status_pengajuan' => 'institusi',
        'institusi' => 'Institusi Asli',
        'email' => 'institusi@example.com',
        'no_hp' => '081234567890',
        'alamat' => 'Alamat Asli',
        'tgl_mulai' => '2026-08-01',
        'tgl_selesai' => '2026-09-01',
    ]);

    actingAs($user)
        ->put(route('admin.update_details', $application->id), [
            'institusi' => 'Institusi Baru',
            'fakultas' => 'Teknik',
            'semester' => '7',
            'jumlah_peserta' => 3,
            'pembimbing' => 'Bpk Pembimbing',
            'kontak_pembimbing' => '08777777777',
            'email' => 'baru_institusi@example.com',
            'no_hp' => '089876543210',
            'alamat' => 'Alamat Kampus Baru',
            'tgl_mulai' => '2026-08-05',
            'tgl_selesai' => '2026-10-05',
        ])
        ->assertRedirect(route('admin.show', $application->id))
        ->assertSessionHas('success', 'Data utama pemohon berhasil diperbarui.');

    $this->assertDatabaseHas('magang_applications', [
        'id' => $application->id,
        'institusi' => 'Institusi Baru',
        'email' => 'baru_institusi@example.com',
        'no_hp' => '089876543210',
        'jumlah_peserta' => 3,
    ]);
});

test('admin cannot update details with invalid phone number or email', function () {
    $user = User::factory()->create();
    $application = MagangApplication::factory()->create([
        'status_pengajuan' => 'mandiri',
    ]);

    actingAs($user)
        ->put(route('admin.update_details', $application->id), [
            'nama' => 'Pendaftar Baru',
            'nik' => '9876543210987654',
            'email' => 'not-an-email', // invalid email
            'no_hp' => '123', // invalid phone number (too short)
            'tgl_lahir' => '2002-02-02',
            'alamat' => 'Alamat Baru',
            'tgl_mulai' => '2026-08-05',
            'tgl_selesai' => '2026-09-10',
        ])
        ->assertSessionHasErrors(['email', 'no_hp']);
});
