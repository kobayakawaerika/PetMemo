<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\MemoController;

Route::get('/', function () {
    return view('welcome');
});

// TOP表示
Route::get('/index', [PetController::class, 'index'])->name('index');