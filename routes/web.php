<?php

use App\Http\Controllers\ClinicsController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\PatientsController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/clinics')->group(function () {
    Route::get('/', [ClinicsController::class, 'index'])->name('clinics.index');
    Route::get('/{id}', [ClinicsController::class, 'show'])->name('clinics.show');
    Route::post('/new', [ClinicsController::class, 'create'])->name('clinics.create');
    Route::post('/{id}/update', [ClinicsController::class, 'update'])->name('clinics.update');
});

Route::prefix('/doctors')->group(function () {
    Route::get('/', [DoctorsController::class, 'index'])->name('doctors.index');
    Route::get('/{id}', [DoctorsController::class, 'show'])->name('doctors.show');
    Route::get('/new', [DoctorsController::class, 'create'])->name('doctors.create');
    Route::get('/update', [DoctorsController::class, 'update'])->name('doctors.update');
});

Route::prefix('/patients')->group(function () {
    Route::get('/', [PatientsController::class, 'index'])->name('patients.index');
    Route::get('/{id}', [PatientsController::class, 'show'])->name('patients.show');
    Route::get('/new', [PatientsController::class, 'create'])->name('patients.create');
    Route::get('/update', [PatientsController::class, 'update'])->name('patients.update');
});

Route::prefix('/results')->group(function () {
    Route::get('/{id}', [PatientsController::class, 'show'])->name('patients.show');
    Route::get('/new', [PatientsController::class, 'create'])->name('patients.create');
    Route::get('/update', [PatientsController::class, 'update'])->name('patients.update');
});
