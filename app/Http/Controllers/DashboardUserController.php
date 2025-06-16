<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori;
use App\Models\Likes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    public function index()
    {
        $menus = Menu::with(['comments.user', 'likes'])->get();

        $likedMenuIds = Auth::check()
            ? Likes::where('user_id', Auth::id())->pluck('menu_id')->toArray()
            : [];

        $data = $menus->map(function ($menu) use ($likedMenuIds) {
            return [
                'id' => $menu->id,
                'title' => $menu->nama_menu,
                'desc' => $menu->deskripsi_menu,
                'image' => $menu->gambar_menu,
                'is_premium' => $menu->is_premium,
                'video_url' => $menu->video_url, // <-- Tambahan di sini
                'likes_count' => $menu->likes->count(),
                'is_liked' => in_array($menu->id, $likedMenuIds),
                'comments' => $menu->comments->map(function ($comment) {
                    return [
                        'user' => $comment->user->name ?? 'Anonim',
                        'text' => $comment->comment_text,
                    ];
                })->toArray(),
            ];
        });

        return view('user.list-resep', ['menus' => $data]);
    }

    public function homepage()
    {
        return view('user.homepage');
    }

    public function kategoriList()
    {
        $kategoris = Kategori::all();
        return view('user.kategori-list', compact('kategoris'));
    }

    public function menuByKategori($id)
    {
        $kategori = Kategori::with('menus')->findOrFail($id); // ambil kategori & semua menunya
        return view('user.menu-by-kategori', compact('kategori'));
    }
}
