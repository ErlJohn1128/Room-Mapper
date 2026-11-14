<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\FloorController;
use App\Http\Controllers\Admin\OverviewController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('app.home')
        : redirect()->route('login');
});

// Missing essential middleware such as rate limiter
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/app', [AppController::class, 'home'])->name('app.home');
    Route::get('/rooms', [AppController::class, 'rooms'])->name('app.rooms');
    Route::get('/schedule', [AppController::class, 'schedule'])->name('app.schedule');
    Route::post('/schedule/leave', [AppController::class, 'createAbsence'])
        ->name('app.schedule.leave');
    Route::delete('/schedule/leave/{absenceId}', [AppController::class, 'cancelAbsence'])
        ->name('app.schedule.leave.cancel');
    Route::get('/settings', [AppController::class, 'settings'])->name('app.settings');
});

// Admin Panel Routes - Protected by Auth & Admin Role Check
Route::prefix('admin')->name('admin.')
    ->group(function () {
        
        Route::get('/overview', [OverviewController::class, 'index'])->name('overview.index');

        // Colleges
        Route::get('/colleges', [CollegeController::class, 'index'])->name('colleges.index');
        Route::get('/colleges/create', [CollegeController::class, 'create'])->name('colleges.create');
        Route::post('/colleges', [CollegeController::class, 'store'])->name('colleges.store');

        Route::put('/colleges/{college_id}/availability', [CollegeController::class, 'toggleAvailability'])->name('colleges.availability');
        Route::get('/colleges/{college_id}', [CollegeController::class, 'show'])->name('colleges.show');
        Route::delete('/colleges/{college_id}', [CollegeController::class, 'destroy'])->name('colleges.destroy');
        Route::get('/colleges/{college_id}/edit', [CollegeController::class, 'edit'])->name('colleges.edit');
        Route::patch('/colleges/{college_id}', [CollegeController::class, 'update'])->name('colleges.update');

        // Buildings
        Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');
        Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create');
        Route::get('/buildings/{building_id}', [BuildingController::class, 'show'])->name('buildings.show');

        Route::post('/buildings', [BuildingController::class, 'store'])->name('buildings.store');

        Route::get('/buildings/{building_id}/edit', [BuildingController::class, 'edit'])->name('buildings.edit');
        Route::patch('/buildings/{building_id}', [BuildingController::class, 'update'])->name('buildings.update');

        Route::put('/buildings/{building_id}/availability', [BuildingController::class, 'toggleAvailability'])->name('buildings.availability');

        // Rooms 
        Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
        Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
        Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
        Route::get('/rooms/edit', [RoomController::class, 'edit'])->name('rooms.edit');
        Route::put('/rooms/{room_id}/availability', [RoomController::class, 'toggleAvailability'])->name('rooms.availability');

        Route::resource('colleges', CollegeController::class);
        Route::resource('buildings', BuildingController::class);
        Route::resource('floors', FloorController::class); 
        Route::resource('rooms', RoomController::class);
        Route::resource('settings', RoomController::class); // To be change
    });