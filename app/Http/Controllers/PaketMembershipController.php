<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaketMembership;

class PaketMembershipController extends Controller
{
    public function index()
    {
        $pakets = PaketMembership::all();
        return view('admin.paket-membership.index', compact('pakets'));
    }

    public function create()
    {
        return view('admin.paket-membership.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'durasi_bulan' => 'required|integer',
            'harga' => 'required|numeric|min:0',
        ]);

        PaketMembership::createPaket($request->all());

        return redirect()->route('admin.paket-membership.index')->with('success', 'Paket membership berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $paket = PaketMembership::findOrFail($id);
        return view('admin.paket-membership.edit', compact('paket'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'durasi_bulan' => 'required|integer',
            'harga' => 'required|numeric|min:0',
        ]);

        $paket = PaketMembership::findOrFail($id);
        $paket->updatePaket($request->all());

        return redirect()->route('admin.paket-membership.index')->with('success', 'Paket membership berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $paket = PaketMembership::findOrFail($id);
        $paket->deletePaket();

        return redirect()->route('admin.paket-membership.index')->with('success', 'Role berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        try {
            $paket = PaketMembership::findOrFail($id);
            $paket->toggleStatus();

            return response()->json([
                'success' => true,
                'message' => 'Status paket berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status.'
            ], 500);
        }
    }
}
