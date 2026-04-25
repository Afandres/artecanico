<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BreedController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('appointment.index');
});

// Ruta pública para el calendario de citas (fuera del middleware auth)
Route::controller(AppointmentController::class)->group(function () {
    Route::get('/appointments/client/{code?}', 'client')->name('appointment.client.index');
    Route::get('/appointments/full-days', 'fullDays')->name('appointment.fullDays');
    Route::get('/appointments/client-events/{code}', 'eventsByCode')->name('appointment.events.code');
    Route::post('/appointments/cancel', 'cancel')->name('appointment.cancel');
    Route::post('/appointments/process', [AppointmentController::class, 'registerProcess'])->name('appointments.process');
});

Route::controller(PetController::class)->group(function () {
    Route::get('/pets/client/{code?}', 'client')->name('pet.client.index');
});

Route::controller(HistoryController::class)->group(function () {
    Route::get('/history/client/{code?}', 'client')->name('history.client.index');
    Route::get('/history/pet/{petId}', 'getPetHistory')->name('history.pet');
    Route::get('/history/appointment/{id}', 'getAppointmentDetails')->name('history.appointment.details');
});


Route::get('/api/pets/{petId}/info', function ($petId) {
    $pet = \App\Models\Pet::with(['client', 'breed'])->findOrFail($petId);
    $name = $pet->name;

    if (auth()->check() && $pet->sobriquet) {
        $name .= ' - ' . $pet->sobriquet;
    }
    
    return response()->json([
        'name' => $name,
        'photo' => $pet->profile_photo ? asset('storage/' . $pet->profile_photo) : null,
        'breed' => $pet->breed->name,
        'age' => $pet->age,
        'gender' => $pet->gender,
        'client_name' => $pet->client->name,
        'client_phone' => $pet->client->emergency_phone
    ]);
})->name('api.pet.info');

// Lista de tratamientos para selects
Route::get('/treatments/list', function () {
    return response()->json(\App\Models\Treatment::all());
})->name('api.treatments.list');

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
            Route::get('/appointments', 'index')->name('appointment.index');
            Route::get('/appointments/events', 'events')->name('appointment.events');
            Route::get('/appointments/pets/search', 'search')->name('appointment.pet.search');
            Route::post('/appointments/store', 'store')->name('appointment.store');
            Route::post('/appointments/state', 'state')->name('appointment.state');
            Route::post('/appointments/cancel-appointment', 'cancelAppointment')->name('appointment.cancel.appointment');
        });

        Route::controller(PetController::class)->group(function () {
            Route::get('/pets', 'index')->name('pet.index');
            Route::get('/pets/breeds', 'getBreeds')->name('pet.breeds');
            Route::get('/pets/clients', 'getClients')->name('pet.clients');
            Route::post('/pets/store', 'store')->name('pet.store');
            Route::post('/pets/update', 'update')->name('pet.update');
            Route::delete('/pets/delete/{id}', 'delete')->name('pet.delete');
            Route::post('/pets/client/update', 'update_client')->name('client.update');
            Route::delete('/pets/client/delete/{id}', 'delete_client')->name('client.delete');
        });

        // Historial
        Route::controller(HistoryController::class)->group(function () {
            Route::get('/history', 'index')->name('history.index');
            Route::post('/history/checkin', 'registerCheckin')->name('history.checkin');
            Route::post('/history/checkout', 'registerCheckout')->name('history.checkout');
            Route::post('/history/process', 'registerProcess')->name('history.process');
        });

        Route::controller(ReportController::class)->group(function () {
            Route::get('/reports/daily', 'daily')->name('report.daily');
            Route::get('/reports/daily/ajax', 'dailyAjax')->name('report.daily.ajax');
            Route::get('/reports/expences', 'expense')->name('report.expenses');
            Route::post('/reports/expences/store', 'store_expense')->name('report.expenses.store');
            Route::post('/reports/expences/update', 'update_expense')->name('report.expenses.update');
            Route::delete('/reports/expences/delete/{id}', 'delete_expense')->name('report.expenses.delete');
            Route::get('/reports/monthly', 'monthly')->name('report.monthly');
            Route::get('/reportes/finance', 'finance')->name('reports.finance');
        });
});
