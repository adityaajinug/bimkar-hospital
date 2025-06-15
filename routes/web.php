<?php

use App\Http\Controllers\DokterController;
use App\Http\Controllers\JadwalPeriksaController;
use App\Http\Controllers\JanjiPeriksaController;
use App\Http\Controllers\MemeriksaController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PeriksaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatPeriksaController;
use App\Models\JadwalPeriksa;
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
})
    ->middleware(['auth'])
    ->name('home.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'role:dokter')->group(function () {
    Route::controller(DokterController::class)
        ->as('dokter.')
        ->prefix('dokter')
        ->group(function () {
            Route::get('/', function () {
                return view('dashboard');
            })->name('index');
        });
    Route::controller(JadwalPeriksaController::class)
        ->as('jadwal-periksa.')
        ->prefix('jadwal-periksa')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::patch('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

    Route::controller(ObatController::class)
        ->as('obat.')
        ->prefix('obat')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });

    Route::controller(MemeriksaController::class)
        ->as('memeriksa.')
        ->prefix('memeriksa')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store/{id}', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::get('/periksa/{id}', 'periksa')->name('periksa');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });
});

Route::middleware('auth', 'role:pasien')->group(function () {
    Route::controller(DokterController::class)
        ->as('pasien.')
        ->prefix('pasien')
        ->group(function () {
            Route::get('/', function () {
                return view('dashboard');
            })->name('index');
        });
    Route::controller(JanjiPeriksaController::class)
        ->as('janji-periksa.')
        ->prefix('janji-periksa')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::put('/update/{id}', 'update')->name('update');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        });
    Route::controller(RiwayatPeriksaController::class)
        ->as('riwayat-periksa.')
        ->prefix('riwayat-periksa')
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });
});

require __DIR__ . '/auth.php';
