<?php

use Illuminate\Support\Facades\Route;
use App\Models\Session;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\SessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/session', [UserController::class, 'ses']);
Route::get('/voting', function(){return View('voting');})->middleware("auth");
Route::post('/login', [UserController::class, 'login']);

Route::get('login', function (){ return View('login') ;})->name("login");
Route::get('logout', [SessionController::class, 'destroy'])->name("logout");


//Route untuk admin
Route::get('/admin', [AdminController::class, 'index'])->middleware("auth:admin");
Route::get('/admin/create', [AdminController::class, 'store']);