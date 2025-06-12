<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profil.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_telepon' => 'nullable|string|max:15',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->update($request->only('name', 'username', 'email', 'no_telepon'));

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture && file_exists(public_path('uploads/profile/' . $user->profile_picture))) {
                unlink(public_path('uploads/profile/' . $user->profile_picture));
            }

            $filename = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('uploads/profile'), $filename);
            $user->profile_picture = $filename;
            $user->save();
        }

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
