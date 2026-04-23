<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagangApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'bidang' => 'array',
    ];

    public function interns()
    {
        return $this->hasMany(Intern::class);
    }
}