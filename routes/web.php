<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenilaianController;
use App\Models\Jabatan;
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

Route::get('/', [PegawaiController::class, 'index'])->name('home');


// Manage Jabatan
Route::get('home/data-jabatan', [JabatanController::class, 'index'])->name('data-jabatan');
Route::post('/create-jabatan', [JabatanController::class, 'store'])->name('create-jabatan');
Route::get('/get-jabatan/{id}', [JabatanController::class, 'edit'])->name('get-jabatanid');
Route::post('/update-jabatan/{kategori}', [JabatanController::class, 'update'])->name('update-jabatan');
// manage jabatan


// manage pegawai
Route::post('/create-pegawai', [PegawaiController::class, 'store'])->name('create-pegawai');
Route::post('/delete-pegawai{id}', [PegawaiController::class, 'destroy'])->name('hapus-data-pegawai');
Route::get('/get-data-pegawai/{id}', [PegawaiController::class, 'edit'])->name('get-pegawaiid');
Route::post('/update-pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('update-pegawai');

// Absensi
Route::get('fetchdataabsen', [AbsensiController::class, 'fetchdataabsen'])->name('fetchdata-absensi');
Route::get('home/data-absensi', [AbsensiController::class, 'index'])->name('data-absensi');



// Penilaian
Route::get('home/data-penilaian', [PenilaianController::class, 'index'])->name('data-penilaian');
