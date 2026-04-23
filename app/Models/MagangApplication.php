<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagangApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_pengajuan',
        'nama',
        'no_hp',
        'email',
        'nik',
        'tgl_lahir',
        'alamat',
        'tgl_mulai',
        'tgl_selesai',
        'bidang',
        'tujuan',
        // Mandiri
        'pendidikan_asal',
        'prodi',
        // Institusi
        'institusi',
        'nim',
        'fakultas',
        'semester',
        'pembimbing',
        'kontak_pembimbing',
        'jumlah_peserta',
        // Files
        'surat_permohonan_path',
        'ktp_path',
        'foto_path',
        'surat_pengantar_path',
        'transkrip_path',
        'proposal_path',
        'status',
        'catatan_admin',
        'laporan_akhir_path'
    ];

    protected $casts = [
        'bidang' => 'array',
        'tgl_lahir' => 'date',
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
    ];

    public function interns()
    {
        return $this->hasMany(Intern::class);
    }
}