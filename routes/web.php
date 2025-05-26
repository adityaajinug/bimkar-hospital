<?php

use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PeriksaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', function () {
    return view('dashboard');
})->middleware(['auth'])->name('home.index');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::controller(PasienController::class)
        ->as('pasien.')
        ->prefix('pasien')
        ->group(function () {
            Route::get('/', 'index')->name('index'); 
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store'); 
            Route::get('/edit/{id}', 'edit')->name('edit'); 
            Route::put('/update/{id}', 'update')->name('update'); 
            Route::delete('/destroy/{id}', 'destroy')->name('destroy'); 
        });

    Route::controller(DokterController::class)
        ->as('dokter.')
        ->prefix('dokter')
        ->group(function () {
            Route::get('/', 'index')->name('index'); 
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store'); 
            Route::get('/edit/{id}', 'edit')->name('edit'); 
            Route::put('/update/{id}', 'update')->name('update'); 
            Route::delete('/destroy/{id}', 'destroy')->name('destroy'); 
        });

    Route::controller(PeriksaController::class)
        ->as('periksa.')
        ->prefix('periksa')
        ->group(function () {
            Route::get('/', 'index')->name('index'); 
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store'); 
            Route::get('/edit/{id}', 'edit')->name('edit'); 
            Route::put('/update/{id}', 'update')->name('update'); 
            Route::delete('/destroy/{id}', 'destroy')->name('destroy'); 
        });
});

Route::middleware('auth', 'role:dokter')->group(function () {
    Route::controller(DokterController::class)
        ->as('dokter.')
        ->prefix('dokter')
        ->group(function () {
            Route::get('/', function() {
                return view('dashboard');
            })->name('index'); 
        });
});

Route::middleware('auth', 'role:pasien')->group(function () {
    Route::controller(DokterController::class)
        ->as('pasien.')
        ->prefix('pasien')
        ->group(function () {
            Route::get('/', function() {
                 return view('dashboard');
            })->name('index'); 
        });
});

require __DIR__.'/auth.php';
