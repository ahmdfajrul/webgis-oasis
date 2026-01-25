<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tanaman;
use Illuminate\Http\Request;

class TanamanController extends Controller
{
    // Menampilkan semua tanaman
    public function index()
    {
        $tanaman = Tanaman::all();
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
        // Validasi input
        $request->validate([
            'kode_pohon'   => ['required', 'string', 'max:50', 'unique:tanaman,kode_pohon'],
            'nama_pohon'   => 'required|string|max:255',
            'nama_latin'   => 'nullable|string|max:255',
            'deskripsi'    => 'nullable|string',
            'tahun_tanam'  => 'required|digits:4|integer',
            'status'       => 'nullable|in:sehat,perhatian,sakit',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
            'foto_pohon'   => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
        ], [
            'kode_pohon.unique' => 'Kode pohon sudah digunakan.'
        ]);

        // Ambil semua data valid dari request
        $data = $request->only([
            'kode_pohon', 'nama_pohon', 'nama_latin', 
            'deskripsi', 'tahun_tanam', 'status', 
            'latitude', 'longitude'
        ]);

        // Upload foto
        if ($request->hasFile('foto_pohon')) {
            $file = $request->file('foto_pohon');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/tanaman'), $namaFile);
            $data['foto_pohon'] = 'tanaman/' . $namaFile;
        }

        // Simpan ke database
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
            'kode_pohon'   => ['sometimes','required','string','max:50', 
                               'unique:tanaman,kode_pohon,'.$id],
            'nama_pohon'   => 'sometimes|required|string|max:255',
            'nama_latin'   => 'nullable|string|max:255',
            'deskripsi'    => 'nullable|string',
            'tahun_tanam'  => 'sometimes|digits:4|integer',
            'status'       => 'sometimes|in:sehat,perhatian,sakit',
            'latitude'     => 'sometimes|numeric',
            'longitude'    => 'sometimes|numeric',
            'foto_pohon'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'kode_pohon.unique' => 'Kode pohon sudah digunakan.'
        ]);

        // Upload foto baru jika ada
        if ($request->hasFile('foto_pohon')) {
            if ($tanaman->foto_pohon) {
                $oldPath = public_path('images/' . $tanaman->foto_pohon);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $file = $request->file('foto_pohon');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/tanaman'), $namaFile);
            $validated['foto_pohon'] = 'tanaman/' . $namaFile;
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

    // Cek apakah kode pohon sudah ada (untuk validasi AJAX)
    public function cekKode(Request $request)
    {
        $exists = Tanaman::where('kode_pohon', $request->kode)->exists();

        return response()->json([
            'exists' => $exists
        ]);
    }
}
