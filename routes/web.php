<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\CollegeController;

Route::get('/', function () {
    return view('home');
});

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/panel', function () {
        return view('admin.panel');
    })->name('panel');

    Route::resource('colleges', CollegeController::class);
    Route::resource('buildings', BuildingController::class);
});