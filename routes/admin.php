<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController


Route::get('/admin', [HomeController::class, 'index'])->name('admin');

Route::resource('office', OfficeController::class);