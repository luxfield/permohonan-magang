<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Setting::updateOrCreate(
            ['key' => 'registration_status'],
            ['value' => 'open']
        );

        \App\Models\Setting::updateOrCreate(
            ['key' => 'registration_closed_message'],
            ['value' => 'Dalam rangka optimalisasi pelaksanaan kegiatan magang, dengan ini disampaikan bahwa kapasitas penerimaan siswa/siswi dan mahasiswa/mahasiswi magang telah terpenuhi, sehingga penerimaan peserta magang ditutup hingga waktu yang belum dapat ditentukan. Pembukaan kembali penerimaan akan diinformasikan melalui website resmi apabila kapasitas telah tersedia']
        );
    }
}
