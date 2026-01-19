<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tanaman;
use App\Models\Penyakit;

class LandingController extends Controller
{
    public function index()
    {
        // Total pohon
        $jumlahTanaman = Tanaman::count();

        // Jumlah jenis pohon (berdasarkan nama pohon)
        $jumlahJenis = Tanaman::distinct('nama_pohon')
                              ->count('nama_pohon');

        // Total jenis penyakit
        $jumlahPenyakit = Penyakit::count();

        return view('frontend.landing', compact(
            'jumlahTanaman',
            'jumlahJenis',
            'jumlahPenyakit'
        ));
    }
}
