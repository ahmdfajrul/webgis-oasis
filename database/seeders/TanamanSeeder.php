<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tanaman;

class TanamanSeeder extends Seeder
{
    public function run(): void
    {
        Tanaman::create([
            'kode_pohon' => 'A01',
            'nama_pohon' => 'Pulai',
            'nama_latin' => 'Samanea saman',
            'tahun_tanam' => 2010,
            'latitude' => -6.780535,
            'longitude' => 110.859251,
            'foto_pohon' => 'tanaman/A01.jpg'
        ]);
    }
}
