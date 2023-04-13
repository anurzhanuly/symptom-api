<?php

use App\Http\Controllers\CitiesController;
use App\Http\Controllers\ClinicsController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\QuestionnairesController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\RecommendationsController;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\SettingsController;
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

Route::post('register', [AuthenticationController::class, 'register']);
Route::post('login', [AuthenticationController::class, 'login']);

Route::middleware('authByToken')->group(function() {
    Route::prefix('/clinics')->group(function () {
        Route::get('/', [ClinicsController::class, 'index'])->name('clinics.index');
        Route::get('/{id}', [ClinicsController::class, 'show'])->name('clinics.show');
        Route::post('/new', [ClinicsController::class, 'create'])->name('clinics.create');
        Route::post('/{id}/update', [ClinicsController::class, 'update'])->name('clinics.update');
    });

    Route::prefix('/doctors')->group(function () {
        Route::get('/cabinet', [DoctorsController::class, 'show'])->name('doctors.show');
        Route::post('/update', [DoctorsController::class, 'update'])->name('doctors.update');
    });

    Route::prefix('/patients')->group(function () {
        Route::get('/cabinet', [PatientsController::class, 'show'])->name('patients.show');
    });
});

Route::prefix('/recommendations')->group(function () {
    Route::post('/', [RecommendationsController::class, 'getRecommendation'])
        ->name('recommendations.getRecommendation');
});

Route::prefix('/settings')->group(function () {
    Route::post('/new', [SettingsController::class, 'create'])->name('settings.create');
    Route::post('/update', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/get-all', [SettingsController::class, 'index'])->name('settings.index');
});

Route::prefix('/questionnaires')->group(function () {
    Route::post('/new', [QuestionnairesController::class, 'create'])
        ->name('questionnaires.create');
    Route::get('/latest', [QuestionnairesController::class, 'show'])
        ->name('questionnaires.show');
    Route::get('/display-options', [QuestionnairesController::class, 'showDisplayOptions'])
        ->name('questionnaires.display-options');
});

Route::prefix('/results')->group(function () {
    Route::get('/{id}', [ResultsController::class, 'show'])->name('results.show');
});

// Технические роуты для форм
Route::get('/cities', [CitiesController::class, 'index'])->name('cities.index');
Route::get('/specializations', [SpecializationsController::class, 'index'])->name('specialization.index');

Route::prefix('/admin')->group(function () {
   Route::prefix('/recommendations')->group(function () {
      Route::get('/', [\App\Http\Controllers\Admin\RecommendationsController::class, 'index'])->name('admin.recommendations.index');
      Route::get('/{id}', [\App\Http\Controllers\Admin\RecommendationsController::class, 'show'])->name('admin.recommendations.show');
      Route::post('/{id}/update', [\App\Http\Controllers\Admin\RecommendationsController::class, 'update'])->name('admin.recommendations.update');
      Route::post('/create', [\App\Http\Controllers\Admin\RecommendationsController::class, 'create'])->name('admin.recommendations.create');
   });
});
