<?php

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

Route::get('/', [App\Http\Controllers\KaryawanController::class, 'welcome'])->name('karyawan.welcome');
Route::post('/absensi', [App\Http\Controllers\AbsensiController::class, 'store'])->name('absensi.store');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    //users
    Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    //karyawan
    Route::get('/data-karyawan', [App\Http\Controllers\KaryawanController::class, 'index'])->name('karyawan.index');
    Route::post('/create-karyawan', [App\Http\Controllers\KaryawanController::class, 'store'])->name('karyawan.store');
    Route::delete('/karyawan/{id}', [App\Http\Controllers\KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    Route::put('/karyawan/{id}', [App\Http\Controllers\KaryawanController::class, 'update'])->name('karyawan.update');

    //manage-company
    Route::get('/manage-company', [App\Http\Controllers\CompanyController::class, 'index'])->name('company.index');
    Route::post('/manage-company', [App\Http\Controllers\CompanyController::class, 'store'])->name('company.store');
    Route::put('/manage-company/{id}', [App\Http\Controllers\CompanyController::class, 'update'])->name('company.update');

    //data absensi
    Route::get('/data-absensi', [App\Http\Controllers\AbsensiController::class, 'index'])->name('absensi.index');
	Route::post('/data-absensi', [App\Http\Controllers\AbsensiController::class, 'store'])->name('absensi.store');

    //jam kerja
    Route::get('/jam-kerja', [App\Http\Controllers\JamKerjaController::class, 'index'])->name('jam-kerja.index');
    Route::post('/jam-kerja', [App\Http\Controllers\JamKerjaController::class, 'saveData'])->name('jam-kerja.saveData');

    //home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});


