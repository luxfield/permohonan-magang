<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MagangApplication>
 */
class MagangApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isMandiri = $this->faker->boolean();
        
        $common = [
            'status_pengajuan' => $isMandiri ? 'mandiri' : 'institusi',
            'nama' => $this->faker->name(),
            'no_hp' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'nik' => $this->faker->numerify('################'), // 16 digit
            'alamat' => $this->faker->address(),
            'tgl_lahir' => $this->faker->date('Y-m-d', '-20 years'),
            'tgl_mulai' => $this->faker->dateTimeBetween('now', '+1 week'),
            'tgl_selesai' => $this->faker->dateTimeBetween('+1 month', '+3 months'),
            'tujuan' => $this->faker->paragraph(),
            'bidang' => null, // Opsional
        ];

        if ($isMandiri) {
            return array_merge($common, [
                'pendidikan_asal' => 'Universitas ' . $this->faker->city(),
                'prodi' => 'Ilmu Hukum',
                'surat_permohonan_path' => 'uploads/dummy/surat.pdf',
                'ktp_path' => 'uploads/dummy/ktp.jpg',
                'foto_path' => 'uploads/dummy/foto.jpg',
            ]);
        }

        return array_merge($common, [
            'institusi' => 'Universitas ' . $this->faker->city(),
            'nim' => $this->faker->numerify('##########'),
            'fakultas' => 'Hukum',
            'semester' => (string) $this->faker->numberBetween(1, 8),
            'pembimbing' => $this->faker->name(),
            'kontak_pembimbing' => $this->faker->phoneNumber(),
            'jumlah_peserta' => (string) $this->faker->numberBetween(1, 5),
            'surat_pengantar_path' => 'uploads/dummy/pengantar.pdf',
            'transkrip_path' => 'uploads/dummy/transkrip.pdf',
            'foto_path' => 'uploads/dummy/foto.jpg',
        ]);
    }
}
