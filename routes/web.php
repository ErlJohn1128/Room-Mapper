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

        // Colleges
        Route::get('/colleges', [CollegeController::class, 'index'])->name('colleges.index');
        Route::post('/colleges', [CollegeController::class, 'store'])->name('colleges.store');
        Route::get('/colleges/create', [CollegeController::class, 'create'])->name('colleges.create');
        Route::get('/colleges/{college_id}/edit', [CollegeController::class, 'edit'])->name('colleges.edit');

        // Buildings
        Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');
        Route::post('/buildings', [BuildingController::class, 'store'])->name('buildings.store');
        Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create');
        Route::get('/buildings/edit', [BuildingController::class, 'edit'])->name('buildings.edit');

        // Rooms 
        Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
        Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
        Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
        Route::get('/rooms/edit', [RoomController::class, 'edit'])->name('rooms.edit');

        Route::resource('colleges', CollegeController::class);
        Route::resource('buildings', BuildingController::class);
        Route::resource('floors', FloorController::class); 
        Route::resource('rooms', RoomController::class);
        Route::resource('settings', RoomController::class); // To be change
    });