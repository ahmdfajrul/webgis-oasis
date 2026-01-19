<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    use HasFactory;

    protected $table = 'penyakit';

    protected $fillable = [
        'tanaman_id',
        'nama_penyakit',
        'foto_penyakit'
    ];

    public function tanaman()
    {
        return $this->belongsTo(Tanaman::class);
    }
}
