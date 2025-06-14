<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuTranslateController;
use App\Http\Controllers\MembershipController;


Route::get('/menu/{id}/translate', [MenuTranslateController::class, 'translate']);
Route::post('/midtrans/callback', [MembershipController::class, 'callback']);
