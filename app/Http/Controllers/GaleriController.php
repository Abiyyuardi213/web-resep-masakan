<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::all();
        return view('admin.galeri.index', compact('galeris'));
    }

    public function create()
    {
        return view('admin.galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only(['judul', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/galeri'), $filename);
            $data['gambar'] = $filename;
        }

        $galeri = new Galeri($data);
        $galeri->id = (string) \Illuminate\Support\Str::uuid();
        $galeri->save();

        return redirect()->route('admin.galeri.index')->with('success', 'Gambar berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $galeri->judul = $request->judul;
        $galeri->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            if ($galeri->gambar && file_exists(public_path('uploads/galeri/' . $galeri->gambar))) {
                unlink(public_path('uploads/gambar/' . $galeri->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/gambar'), $filename);
            $galeri->gambar = $filename;
        }

        $galeri->save();

        return redirect()->route('admin.galeri.index')->with('success', 'Sponsor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);
        $galeri->deleteGambar();

        return redirect()->route('admin.galeri.index')->with('success', 'Gambar berhasil dihapus.');
    }
}
