<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tanaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class TanamanController extends Controller
{
    public function index()
    {
        $tanaman = Tanaman::all();
        return view('admin.tanaman.index', compact('tanaman'));
    }

    public function create()
    {
        return view('admin.tanaman.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'kode_pohon' => ['required', 'string', 'max:50', 'unique:tanaman,kode_pohon'],
        'nama_pohon' => 'required',
        'tahun_tanam' => 'required|numeric',
        'latitude' => 'required',
        'longitude' => 'required',
        'foto_pohon' => 'required|image'
    ], [
        'kode_pohon.unique' => 'Kode pohon sudah digunakan.'
    ]);
        $file = $request->file('foto_pohon');
        $namaFile = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('images/tanaman'), $namaFile);

        $data['foto_pohon'] = 'tanaman/'.$namaFile;

        Tanaman::create($data);

        return redirect()->route('admin.tanaman.index');
    }

    public function edit($id)
    {
        $tanaman = Tanaman::findOrFail($id);
        return view('admin.tanaman.edit', compact('tanaman'));
    }

    public function update(Request $request, $id)
    {
        $tanaman = Tanaman::findOrFail($id);

        $validated = $request->validate([
            'nama_pohon'   => 'sometimes|required|string|max:255',
            'nama_latin'   => 'nullable|string|max:255',
            'tahun_tanam'  => 'sometimes|digits:4|integer',
            'status'       => 'sometimes|in:sehat,perhatian,sakit',
            'latitude'     => 'sometimes|numeric',
            'longitude'    => 'sometimes|numeric',
            'foto_pohon'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',//5mb
        ]);

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

        return redirect()
            ->route('admin.tanaman.index')
            ->with('success', 'Data tanaman berhasil diperbarui.');
    }

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

        return redirect()->route('admin.tanaman.index');
    }

    public function cekKode(Request $request)
{
    $exists = Tanaman::where('kode_pohon', $request->kode)->exists();

    return response()->json([
        'exists' => $exists
    ]);
}

}