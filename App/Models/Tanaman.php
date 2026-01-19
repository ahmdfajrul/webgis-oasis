<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanaman extends Model
{
    use HasFactory;

    protected $table = 'tanaman';

    protected $fillable = [
        'kode_pohon',
        'nama_pohon',
        'nama_latin',
        'tahun_tanam',
        'status',
        'latitude',
        'longitude',
        'foto_pohon'
    ];

    public function penyakit()
    {
        return $this->hasMany(Penyakit::class);
    }
}
