<?php


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('/user/dashboard')->group(function () {

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/', 'userIndex')->name('user.dashboard');
        Route::post('/update/name', 'UpdateName')->name('user.update.name');
        Route::post('/update/password', 'UpdatePassword')->name('user.update.password');
        Route::get('/update/profile', 'UpdateProfile')->name('user.update.profile');
    });
});
