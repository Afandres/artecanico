<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BreedController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return redirect()->route('appointment.index');
});
    
Route::controller(AppointmentController::class)->group(function () {
    Route::get('/appointments', 'index')->name('appointment.index');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])
->group(function () {

    Route::controller(BreedController::class)->group(function () {
        Route::get('/breeds', 'index')->name('breed.index');
        Route::post('/breeds/store', 'store')->name('breed.store');
        Route::post('/breeds/update', 'update')->name('breed.update');
        Route::delete('/breeds/delete/{id}', 'delete')->name('breed.delete');

    });

    Route::controller(TreatmentController::class)->group(function () {
        Route::get('/treatments', 'index')->name('treatment.index');
        Route::post('/treatments/store', 'store')->name('treatment.store');
        Route::post('/treatments/update', 'update')->name('treatment.update');
        Route::delete('/treatments/delete/{id}', 'delete')->name('treatment.delete');
    });
});
