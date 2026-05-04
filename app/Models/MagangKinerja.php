<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagangKinerja extends Model
{
    use HasFactory;

    protected $fillable = [
        'magang_application_id',
        'judul',
        'deskripsi',
        'file_path',
        'komentar_admin',
    ];

    public function application()
    {
        return $this->belongsTo(MagangApplication::class, 'magang_application_id');
    }
}