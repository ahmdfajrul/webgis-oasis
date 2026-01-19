<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penyakit;
use App\Models\Tanaman;

class PenyakitSeeder extends Seeder
{
    public function run(): void
    {
        $tanaman = Tanaman::where('kode_pohon', 'A01')->first();

        Penyakit::create([
            'tanaman_id' => $tanaman->id,
            'nama_penyakit' => 'puru',
            'foto_penyakit' => 'penyakit/puru_A01.jpg'
        ]);
    }
}
