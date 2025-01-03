<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\VotingController;



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


//ROute untuk user
Route::get('/user', [UserController::class, 'index'])->middleware("auth:sanctum");
Route::put('/user', [UserController::class, 'update'])->middleware("auth:sanctum");
Route::post('/user', [UserController::class, 'store'])->middleware("auth:sanctum");
Route::delete('/user', [UserController::class, 'destroy'])->middleware("auth:sanctum");


Route::get('/session', [UserController::class, 'ses']);
Route::get('/logout', [SessionController::class, 'destroy']);
Route::post('/login', [UserController::class, 'login']);


Route::get('/voting', [VotingController::class, 'index']);
Route::put('/voting', [VotingController::class, 'update'])->middleware('auth:sanctum');
Route::post('/voting', [VotingController::class, 'store'])->middleware('auth:sanctum');
Route::patch('/voting', [VotingController::class, 'elect'])->middleware('auth:sanctum');
Route::delete('/voting', [VotingController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/user/voting', [VotingController::class, 'userVote']);

Route::post('/check', [VotingController::class, 'check']);

