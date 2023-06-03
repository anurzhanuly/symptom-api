<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('/', [
        Admin\IndexController::class,
        'index',
    ])->name('admin.index');

    Route::prefix('cities')->group(function () {
        Route::get('/', [
            Admin\CityController::class,
            'index'
        ])->name('city.index');

        Route::post('/create', [
            Admin\CityController::class,
            'create'
        ])->name('city.create');
    });

    Route::prefix('clinic')->group(function () {
        Route::get('/', [
            Admin\ClinicController::class,
            'index'
        ])->name('clinic.index');

        Route::post('/create', [
            Admin\ClinicController::class,
            'create'
        ])->name('clinic.create');
    });

    Route::prefix('doctor')->group(function () {
        Route::get('/', [
            Admin\DoctorController::class,
            'index'
        ])->name('doctor.index');

        Route::post('/create', [
            Admin\DoctorController::class,
            'create'
        ])->name('doctor.create');
    });
});
