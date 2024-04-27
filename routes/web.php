<?php

use App\Http\Controllers\PencatatanKuponMakanController;
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

Route::get('/', function () {
    return redirect('/scan-active');
});


Route::get('/scan-active', [PencatatanKuponMakanController::class, 'showScanActiveForm'])->name('scan.active');

// Route untuk menampilkan formulir pemindaian QR nonaktif
Route::get('/scan-inactive', [PencatatanKuponMakanController::class, 'showScanInactiveForm'])->name('scan.inactive');
// Route untuk menyimpan pencatatan kupon makan dari pemindaian QR aktif
Route::post('/save-scan-active', [PencatatanKuponMakanController::class, 'storeScanActive'])->name('scan.active.store');
Route::post('/save-scan-inactive', [PencatatanKuponMakanController::class, 'storeScanIactive'])->name('scan.inactive.store');


// Route untuk menampilkan rekap hasil scan kupon makan perhari
Route::get('/rekap', [PencatatanKuponMakanController::class, 'showRekap'])->name('rekap.show');


Route::get('/laporan', [PencatatanKuponMakanController::class, 'showLaporanRekap'])->name('laporan.show');
