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
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\PaketMembershipController;
use App\Http\Controllers\TransactionController;
//use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Http\Middleware\VerifyCsrfToken;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/home', [HomeController::class, 'index']);
Route::get('/about', [AboutController::class, 'index']);
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
Route::get('/galeri-list', [GaleriController::class, 'galeriList'])->name('galeri.list');
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

    Route::resource('galeri', GaleriController::class);

    Route::post('paket-membership/{id}/toggle-status', [PaketMembershipController::class, 'toggleStatus'])->name('paket-membership.toggleStatus');
    Route::resource('paket-membership', PaketMembershipController::class);

    Route::resource('transaction', TransactionController::class)->only(['index', 'show']);
});

Route::name('users')->middleware('users')->group(function () {
    Route::get('/homepage', [DashboardUserController::class, 'homepage'])->name('users.homepage.user');
    Route::get('/list-resep', [DashboardUserController::class, 'index'])->name('users.dashboard.user');
    Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');
    //Route::get('/menu/{id}/detail', [MenuController::class, 'detail'])->name('menu.detail');
    Route::get('/kategori-list', [DashboardUserController::class, 'kategoriList'])->name('user.kategori-list');
    Route::get('/kategori/{id}', [DashboardUserController::class, 'menuByKategori'])->name('user.menu-by-kategori');
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::post('/profil', [ProfilController::class, 'update'])->name('profil.update');
});

Route::get('/menu/{id}/detail', [MenuController::class, 'detail'])->name('menu.detail');

Route::middleware(['auth', 'check.membership'])->group(function () {
    Route::get('/member/dashboard', [MemberController::class, 'index'])->name('member.dashboard');
});

//Route::post('/midtrans/notification', [MembershipController::class, 'handleNotification']);
Route::post('/midtrans/notification', [MembershipController::class, 'handleNotification'])
    ->withoutMiddleware([VerifyCsrfToken::class]);

Route::middleware('auth')->group(function () {
    Route::post('/menu/{id}/like', [LikesController::class, 'toggle'])->name('menu.like');
    Route::post('/menu/comment', [CommentsController::class, 'store'])->name('menu.comment');
    Route::get('/upgrade', [MembershipController::class, 'index'])->name('membership.index');
    Route::post('/upgrade/process', [MembershipController::class, 'process'])->name('membership.process');
    Route::post('/membership/checkout', [MembershipController::class, 'checkout'])->name('membership.checkout');
});

Route::get('/test-translate', function () {
    return view('test-translate');
});

Route::get('/payment/{id}', [TransactionController::class, 'payment'])->middleware('auth');

// require base_path('routes/api.php');
