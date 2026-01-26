<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tanaman;
use Illuminate\Http\Request;

class TanamanController extends Controller
{
    // Menampilkan semua tanaman dengan paginate 10
    public function index()
    {
        $tanaman = Tanaman::select(
                'id',
                'kode_pohon',
                'nama_pohon',
                'nama_latin',
                'status',
                'latitude',
                'longitude',
                'foto_pohon'
            )
            ->with('penyakit:id,tanaman_id,nama_penyakit,foto_penyakit')
            ->orderByRaw("SUBSTRING(kode_pohon,1,1), CAST(SUBSTRING(kode_pohon,2) AS UNSIGNED) ASC");

        return view('admin.tanaman.index', compact('tanaman'));
    }

    // Form tambah tanaman
    public function create()
    {
        return view('admin.tanaman.create');
    }

    // Simpan data tanaman baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_pohon'   => 'required|string|max:50|unique:tanaman,kode_pohon',
            'nama_pohon'   => 'required|string|max:255',
            'nama_latin'   => 'nullable|string|max:255',
            'deskripsi'    => 'nullable|string',
            'tahun_tanam'  => 'required|digits:4|integer',
            'status'       => 'nullable|in:sehat,perhatian,sakit',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
            'foto_pohon'   => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'kode_pohon.unique' => 'Kode pohon sudah digunakan.'
        ]);

        $data = $request->only([
            'kode_pohon',
            'nama_pohon',
            'nama_latin',
            'deskripsi',
            'tahun_tanam',
            'status',
            'latitude',
            'longitude'
        ]);

        if ($request->hasFile('foto_pohon')) {
            $file = $request->file('foto_pohon');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/tanaman'), $namaFile);
            $data['foto_pohon'] = 'tanaman/'.$namaFile;
        }

        Tanaman::create($data);

        return redirect()->route('admin.tanaman.index')
                         ->with('success', 'Data tanaman berhasil ditambahkan.');
    }

    // Form edit tanaman
    public function edit($id)
    {
        $tanaman = Tanaman::findOrFail($id);
        return view('admin.tanaman.edit', compact('tanaman'));
    }

    // Update data tanaman
    public function update(Request $request, $id)
    {
        $tanaman = Tanaman::findOrFail($id);

        $validated = $request->validate([
            'kode_pohon'   => 'required|string|max:50|unique:tanaman,kode_pohon,'.$id,
            'nama_pohon'   => 'required|string|max:255',
            'nama_latin'   => 'nullable|string|max:255',
            'deskripsi'    => 'nullable|string',
            'tahun_tanam'  => 'required|digits:4|integer',
            'status'       => 'nullable|in:sehat,perhatian,sakit',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
            'foto_pohon'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'kode_pohon.unique' => 'Kode pohon sudah digunakan.'
        ]);

        if ($request->hasFile('foto_pohon')) {
            if ($tanaman->foto_pohon) {
                $oldPath = public_path('images/' . $tanaman->foto_pohon);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $file = $request->file('foto_pohon');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/tanaman'), $namaFile);
            $validated['foto_pohon'] = 'tanaman/'.$namaFile;
        }

        $tanaman->update($validated);

        return redirect()->route('admin.tanaman.index')
                         ->with('success', 'Data tanaman berhasil diperbarui.');
    }

    // Hapus tanaman
    public function destroy($id)
    {
        $tanaman = Tanaman::findOrFail($id);

        if ($tanaman->foto_pohon) {
            $path = public_path('images/' . $tanaman->foto_pohon);
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        $tanaman->delete();

        return redirect()->route('admin.tanaman.index')
                         ->with('success', 'Data tanaman berhasil dihapus.');
    }

    // Cek kode pohon via AJAX
    public function cekKode(Request $request)
    {
        $kode = $request->kode;
        $exists = Tanaman::where('kode_pohon', $kode)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }

    public function updateLocation(Request $request, $id){
    $tanaman = Tanaman::findOrFail($id);
    $tanaman->update([
        'latitude' => $request->latitude,
        'longitude' => $request->longitude
    ]);
    return response()->json(['success'=>true]);
}

}
