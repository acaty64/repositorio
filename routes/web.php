<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\OfficeController;


Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');

require __DIR__.'/auth.php';
