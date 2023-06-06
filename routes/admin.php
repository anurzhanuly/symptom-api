<?php

use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::middleware('authAdmin')->get('/', [
        Admin\IndexController::class,
        'index',
    ])->name('admin.index');

    Route::prefix('cities')->middleware('authAdmin')->group(function () {
        Route::get('/', [
            Admin\CityController::class,
            'index'
        ])->name('city.index');

        Route::post('/create', [
            Admin\CityController::class,
            'create'
        ])->name('city.create');
    });

    Route::prefix('clinic')->middleware('authAdmin')->group(function () {
        Route::get('/', [
            Admin\ClinicController::class,
            'index'
        ])->name('clinic.index');

        Route::post('/create', [
            Admin\ClinicController::class,
            'create'
        ])->name('clinic.create');

        Route::get('/delete', [
            Admin\ClinicController::class,
            'delete'
        ])->name('clinic.delete');
    });

    Route::prefix('specialization')->middleware('authAdmin')->group(function () {
        Route::get('/', [
            Admin\SpecializationController::class,
            'index'
        ])->name('specialization.index');

        Route::post('/create', [
            Admin\SpecializationController::class,
            'create'
        ])->name('specialization.create');

        Route::get('/delete', [
            Admin\SpecializationController::class,
            'delete'
        ])->name('specialization.delete');
    });

    Route::prefix('doctor')->middleware('authAdmin')->group(function () {
        Route::get('/', [
            Admin\DoctorController::class,
            'index'
        ])->name('doctor.index');

        Route::get('/create', [
            Admin\DoctorController::class,
            'create'
        ])->name('doctor.create');

        Route::post('/create', [
            Admin\DoctorController::class,
            'handleCreate'
        ])->name('doctor.handleCreate');

        Route::get('/delete', [
            Admin\DoctorController::class,
            'delete'
        ])->name('doctor.delete');
    });

    Route::get('/auth', [
        Admin\AuthController::class,
        'index'
    ])->name('auth.index');

    Route::post('/auth', [
        Admin\AuthController::class,
        'handle'
    ])->name('auth.handle');
});
