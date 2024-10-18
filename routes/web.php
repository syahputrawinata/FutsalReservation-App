<?php

use Illuminate\Support\Facades\Route;
// use: import file : namespace\namaclass\
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Models\Reservation;

Route::get('/', function () {
    return view('landing-page');
})->name('home');

Route::get('/user', function () {
    return view('user.index');
});

Route::prefix('/reservations')->name('reservations.')->group(function(){
    Route::get('/', [ReservationController::class, 'index'])->name('index'); // Menampilkan daftar lapangan
    Route::get('/create', [ReservationController::class, 'create'])->name('create'); // Form tambah lapangan
    Route::post('/store', [ReservationController::class, 'store'])->name('store'); // Menyimpan lapangan baru
    Route::get('/{id}', [ReservationController::class, 'edit'])->name('edit');
    Route::patch('/{id}', [ReservationController::class, 'update'])->name('update');
    Route::delete('/{reservation}', [ReservationController::class, 'destroy'])->name('delete');
});


Route::prefix('/user')->name('user.')->group(function(){
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/', [UserController::class, 'index'])->name('home');
    Route::get('/{id}', [UserController::class, 'edit'])->name('edit');
    Route::patch('/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');
});

