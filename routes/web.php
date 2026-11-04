<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\FloorController;
use App\Http\Controllers\Admin\OverviewController;
use App\Http\Controllers\RoomController;

Route::get('/', function () {
    return view('home');
});

// Admin Panel Routes - Protected by Auth & Admin Role Check
Route::prefix('admin')->name('admin.')
    ->group(function () {
         // ->middleware(['auth', 'can:admin'])
        
        Route::get('/overview', [OverviewController::class, 'index'])->name('overview.index');
        Route::get('/colleges', [CollegeController::class, 'index'])->name('colleges.index');
        Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');
        Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');

        Route::resource('colleges', CollegeController::class);
        Route::resource('buildings', BuildingController::class);
        Route::resource('floors', FloorController::class);
        Route::resource('rooms', RoomController::class);
    });