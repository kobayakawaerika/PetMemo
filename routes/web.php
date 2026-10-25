<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\MemoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/index', [PetController::class, 'index'])->name('index');
    Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('/pets/store', [PetController::class, 'store'])->name('pets.store');

    // 編集画面
    Route::get('pets/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit');

    // 更新用
    Route::post('pets/{pet}/update', [PetController::class, 'update'])->name('pets.update');

    // ペットメモ追加用
    Route::post('pets/{pet}/memo', [MemoController::class, 'memos'])->name('pets.memo');

    // ペットメモ削除用
    Route::delete('memos/{memo}', [MemoController::class, 'delete'])->name('memos.delete');

    // ペット削除用
    Route::delete('pets/{pet}/delete', [PetController::class, 'delete'])->name('pets.delete');

    // 体重記録
    Route::post('/pets/weight/{pet}', [PetController::class, 'weight'])->name('pets.weight');

    // 体重の削除
    Route::delete('/pets/weights/{weightLog}', [PetController::class, 'weightDelete'])->name('weights.delete');
});

require __DIR__ . '/auth.php';
