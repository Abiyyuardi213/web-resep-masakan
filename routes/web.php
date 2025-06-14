<?php

use App\Http\Controllers\AboutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\GaleriController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
Route::get('/contact', [ContactController::class, 'index']);

Route::get('/login-user', [AuthController::class, 'showUserLoginForm'])->name('login-user');
Route::post('/login-user', [AuthController::class, 'userLogin']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/auth-google-redirect', [AuthController::class, 'googleRedirect']);
Route::get('/auth-google-callback', [AuthController::class, 'googleCallback']);

Route::get('/login-admin', [AuthController::class, 'showAdminLoginForm'])->name('login-admin');
Route::post('/login-admin', [AuthController::class, 'adminLogin'])->name('login-admin.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('menu', MenuController::class);

Route::name('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard-admin', [DashboardController::class, 'index'])->name('dashboard.admin');

    Route::resource('role', RoleController::class);
    Route::post('role/{id}/toggle-status', [RoleController::class, 'toggleStatus'])->name('role.toggleStatus');

    Route::resource('user', UserController::class);

    Route::resource('kategori', KategoriController::class);

    Route::put('/comments/{id}', [CommentsController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{id}', [CommentsController::class, 'destroy'])->name('comments.destroy');

    Route::get('/ingredients/menu/{menu_id}', [IngredientsController::class, 'indexByMenu']);
    Route::post('/ingredients', [IngredientsController::class, 'store']);
    Route::put('/ingredients/{id}', [IngredientsController::class, 'update']);
    Route::delete('/ingredients/{id}', [IngredientsController::class, 'destroy']);

    Route::resource('tags', TagsController::class);
    Route::resource('sponsor', SponsorController::class);

    // Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
    // Route::get('/galeri/create', [GaleriController::class, 'create'])->name('galeri.create');
    // Route::post('/galeri', [GaleriController::class, 'store'])->name('galeri.store');
    // Route::get('/galeri/show', [GaleriController::class, 'show'])->name('galeri.show');
    // Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');
    Route::resource('galeri', GaleriController::class);
});

Route::name('users')->middleware('users')->group(function () {
    Route::get('/homepage', [DashboardUserController::class, 'homepage'])->name('users.homepage.user');
    Route::get('/dashboard-user', [DashboardUserController::class, 'index'])->name('users.dashboard.user');
    Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');
    Route::get('/menu/{id}/detail', [MenuController::class, 'detail'])->name('menu.detail');
    Route::get('/kategori-list', [DashboardUserController::class, 'kategoriList'])->name('user.kategori-list');
    Route::get('/kategori/{id}', [DashboardUserController::class, 'menuByKategori'])->name('user.menu-by-kategori');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::post('/profil', [ProfilController::class, 'update'])->name('profil.update');
});

Route::middleware(['auth', 'check.membership'])->group(function () {
    Route::get('/member/dashboard', [MemberController::class, 'index'])->name('member.dashboard');
});

// Route untuk user login (semua role)
Route::middleware('auth')->group(function () {
    Route::post('/menu/{id}/like', [LikesController::class, 'toggle'])->name('menu.like');
    Route::post('/menu/comment', [CommentsController::class, 'store'])->name('menu.comment');
    Route::get('/upgrade', [MembershipController::class, 'index'])->name('membership.index');
    Route::post('/upgrade/process', [MembershipController::class, 'process'])->name('membership.process');
    Route::post('/midtrans/callback', [MembershipController::class, 'callback'])->name('membership.callback');
    Route::post('/upgrade/process', [MembershipController::class, 'process'])->name('membership.process');
});

Route::get('/test-translate', function () {
    return view('test-translate');
});

require base_path('routes/api.php');
