<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Menu;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Menu::with('kategori')->latest()->get();
        $sponsors = Sponsor::latest()->get();
        $galeris = Galeri::latest()->get();

        return view('home', compact('menus', 'sponsors', 'galeris'));
    }
}
