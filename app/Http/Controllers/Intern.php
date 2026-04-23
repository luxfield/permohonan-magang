<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    use HasFactory;

    protected $fillable = [
        'magang_application_id',
        'user_id',
        'nama',
        'email',
        'nim',
    ];

    public function application()
    {
        return $this->belongsTo(MagangApplication::class, 'magang_application_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}