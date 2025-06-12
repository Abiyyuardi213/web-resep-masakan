<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'gambar_kategori' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Kategori::createKategori($request->only('nama_kategori'));
        $data = $request->only(['nama_kategori']);

        if ($request->hasFile('gambar_kategori')) {
            $file = $request->file('gambar_kategori');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/kategori'), $filename);
            $data['gambar_kategori'] = $filename;
        }

        $kategori = new Kategori($data);
        $kategori->id = (string) \Illuminate\Support\Str::uuid();
        $kategori->save();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'nama_kategori' => 'required|string|max:255',
    //         'gambar_kategori' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //     ]);

    //     $kategori = Kategori::findOrFail($id);
    //     $kategori->updateKategori($request->only('nama_kategori'));

    //     return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    // }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'gambar_kategori' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $kategori->nama_kategori = $request->nama_kategori;

        if ($request->hasFile('gambar_kategori')) {
            if ($kategori->gambar_kategori && file_exists(public_path('uploads/kategori/' . $kategori->gambar_kategori))) {
                unlink(public_path('uploads/kategori/' . $kategori->gambar_kategori));
            }

            $file = $request->file('gambar_kategori');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/kategori'), $filename);
            $kategori->gambar_kategori = $filename;
        }

        $kategori->save();

        return redirect()->route('admin.kategori.index')->with('success', 'Sponsor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->deleteKategori();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->toggleStatus();

            return response()->json([
                'success' => true,
                'message' => 'Status kategori berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status.'
            ], 500);
        }
    }
}
