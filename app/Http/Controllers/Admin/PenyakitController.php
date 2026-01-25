<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penyakit;
use App\Models\Tanaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PenyakitController extends Controller
{
    public function index()
{
    $penyakit = Penyakit::with('tanaman')
        ->join('tanaman', 'penyakit.tanaman_id', '=', 'tanaman.id')
        ->orderByRaw("SUBSTRING(tanaman.kode_pohon,1,1), CAST(SUBSTRING(tanaman.kode_pohon,2) AS UNSIGNED) ASC")
        ->select('penyakit.*')
        ->paginate(20);

    return view('admin.penyakit.index', compact('penyakit'));
}


    public function create()
    {
        $tanaman = Tanaman::all();
        return view('admin.penyakit.create', compact('tanaman'));
    }

    // SIMPAN DATA BARU
    public function store(Request $request)
    {
        $data = $request->validate([
            'tanaman_id'    => 'required',
            'nama_penyakit' => 'required',
            'deskripsi'     => 'nullable',
            'foto_penyakit' => 'required|image'
        ]);

        // upload foto
        $file = $request->file('foto_penyakit');
        $namaFile = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('images/penyakit'), $namaFile);

        $data['foto_penyakit'] = 'penyakit/'.$namaFile;

        Penyakit::create($data);

        return redirect()->route('admin.penyakit.index');
    }

    // FORM EDIT
    public function edit($id)
    {
        $penyakit = Penyakit::findOrFail($id);
        $tanaman  = Tanaman::all();

        return view('admin.penyakit.edit', compact('penyakit', 'tanaman'));
    }

    // UPDATE DATA
    public function update(Request $request, $id)
    {
        $penyakit = Penyakit::findOrFail($id);

        $data = $request->validate([
            'tanaman_id'    => 'required',
            'nama_penyakit' => 'required',
            'deskripsi'     => 'nullable',
            'foto_penyakit' => 'nullable|image'
        ]);

        // jika ganti foto
        if ($request->hasFile('foto_penyakit')) {

            // hapus foto lama
            $path = public_path('images/'.$penyakit->foto_penyakit);
            if (File::exists($path)) {
                File::delete($path);
            }

            // upload foto baru
            $file = $request->file('foto_penyakit');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/penyakit'), $namaFile);

            $data['foto_penyakit'] = 'penyakit/'.$namaFile;
        }

        $penyakit->update($data);

        return redirect()->route('admin.penyakit.index');
    }

    // HAPUS DATA
    public function destroy($id)
    {
        $penyakit = Penyakit::findOrFail($id);

        // hapus foto
        $path = public_path('images/'.$penyakit->foto_penyakit);
        if (File::exists($path)) {
            File::delete($path);
        }

        $penyakit->delete();

        return redirect()->route('admin.penyakit.index');
    }
}
