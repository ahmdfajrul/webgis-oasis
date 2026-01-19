<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tanaman;
use App\Models\Penyakit;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTanaman = Tanaman::count();
        $totalPenyakit = Penyakit::count();

        $tanamanPerJenis = Tanaman::selectRaw('nama_pohon, count(*) as total')
            ->groupBy('nama_pohon')->get();

        $penyakitPerTanaman = Penyakit::with('tanaman')->get();

        return view('admin.dashboard', compact(
            'totalTanaman',
            'totalPenyakit',
            'tanamanPerJenis',
            'penyakitPerTanaman'
        ));
    }
}
