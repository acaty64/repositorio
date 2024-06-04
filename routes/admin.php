<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\TdocController;

//Route::get('', [HomeController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/index', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //Route::resource('profile', ProfileController::class)->names('admin.profile');
});

Route::middleware('auth')->group(function () {
    
    Route::resource('permission', PermissionController::class)->names('admin.permission');
    Route::resource('role', RoleController::class)->names('admin.role');
    Route::resource('document', DocumentController::class)->names('admin.document');
    Route::resource('target', DocumentController::class)->names('admin.target');
    Route::resource('office', OfficeController::class)->names('admin.office');
    Route::resource('tdoc', TdocController::class)->names('admin.tdoc');
});