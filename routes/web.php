<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BreedController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PetController;

Route::get('/', function () {
    return redirect()->route('appointment.index');
});
    
Route::controller(AppointmentController::class)->group(function () {
    Route::get('/appointments', 'index')->name('appointment.index');
    Route::get('/appointments/events', 'events')->name('appointment.events');
    Route::get('/appointments/full-days', 'fullDays')->name('appointment.fullDays');
    Route::get('/appointments/client/{code}', 'eventsByCode')->name('appointment.events.code');
    Route::post('/appointments/cancel', 'cancel')->name('appointment.cancel');
}); 

Route::controller(PetController::class)->group(function () {
    Route::get('/pets', 'index')->name('pet.index');
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

    Route::controller(AppointmentController::class)->group(function () {
        Route::get('/appointments/pets/search', 'search')->name('appointment.pet.search');
        Route::post('/appointments/store', 'store')->name('appointment.store');
        Route::post('/appointments/state', 'state')->name('appointment.state');
    });

    Route::controller(PetController::class)->group(function () {
        Route::get('/pets/breeds', 'getBreeds')->name('pet.breeds');
        Route::get('/pets/clients', 'getClients')->name('pet.clients');
        Route::post('/pets/store', 'store')->name('pet.store');
    });
});
