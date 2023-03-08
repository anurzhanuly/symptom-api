<?php

use App\Http\Controllers\CitiesController;
use App\Http\Controllers\ClinicsController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RecommendationsController;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\SpecializationsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::prefix('/clinics')->group(function () {
    Route::get('/', [ClinicsController::class, 'index'])->name('clinics.index');
    Route::get('/{id}', [ClinicsController::class, 'show'])->name('clinics.show');
    Route::post('/new', [ClinicsController::class, 'create'])->name('clinics.create');
    Route::post('/{id}/update', [ClinicsController::class, 'update'])->name('clinics.update');
});

Route::prefix('/doctors')->group(function () {
    Route::get('/', [DoctorsController::class, 'index'])->name('doctors.index');
    Route::get('/{id}', [DoctorsController::class, 'show'])->name('doctors.show');
    Route::post('/new', [DoctorsController::class, 'create'])->name('doctors.create');
    Route::post('/{id}/update', [DoctorsController::class, 'update'])->name('doctors.update');
});

Route::prefix('/patients')->group(function () {
    Route::get('/', [PatientsController::class, 'index'])->name('patients.index');
    Route::get('/{id}', [PatientsController::class, 'show'])->name('patients.show');
    Route::get('/new', [PatientsController::class, 'create'])->name('patients.create');
    Route::get('/{id}/update', [PatientsController::class, 'update'])->name('patients.update');
});

Route::prefix('/recommendations')->group(function () {
    Route::post('/', [RecommendationsController::class, 'getRecommendation'])
        ->name('recommendations.getRecommendation');
});

Route::prefix('/results')->group(function () {
    Route::get('/{id}', [ResultsController::class, 'show'])->name('results.show');
});

// Технические роуты для форм
Route::get('/cities', [CitiesController::class, 'index'])->name('cities.index');
Route::get('/specializations', [SpecializationsController::class, 'index'])->name('specialization.index');
