<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tanaman;

class MapController extends Controller
{
    public function index()
    {
        $tanaman = Tanaman::select('id', 'nama_pohon', 'latitude', 'longitude', 'status', 'foto_pohon')->get();
        return view('frontend.map', compact('tanaman'));
    }

    public function detail($id)
    {
        $tanaman = Tanaman::findOrFail($id);
        return view('frontend.detail', compact('tanaman'));
    }
}

