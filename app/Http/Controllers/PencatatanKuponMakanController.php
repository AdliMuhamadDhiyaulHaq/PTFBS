<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PencatatanKuponMakan;
use Milon\Barcode\QRcode;

class PencatatanKuponMakanController extends Controller
{
    public function showScanActiveForm()
    {
        return view('scan_active_form');
    }

    public function showScanInactiveForm()
    {
        return view('scan_inactive_form');
    }


    public function storeScanActive(Request $request)
    {
        // Validasi data
        $request->validate([
            'kupon_code' => 'required', // Tidak perlu validasi unique, karena kita akan memeriksa keberadaan QR code
            // Mungkin ada validasi tambahan terkait pemindaian aktif
        ]);

        // Cek apakah kode kupon sudah ada dalam database
        $existingRecord = PencatatanKuponMakan::where('kupon_code', $request->kupon_code)->exists();

        if ($existingRecord) {
            return response()->json(['success' => false, 'error' => 'Kupon sudah digunakan sebelumnya.'], 422);
        } else {
            // QR code terdeteksi, simpan pencatatan kupon makan
            PencatatanKuponMakan::create([
                'kupon_code' => $request->kupon_code,
                'scan_method' => 'Aktif',
                'scan_time' => now(),
            ]);

            return response()->json(['success' => true, 'message' => 'Pencatatan kupon makan berhasil disimpan.']);
        }
    }
    public function storeScanIactive(Request $request)
    {
        // Validasi data
        $request->validate([
            'kupon_code' => 'required', // Tidak perlu validasi unique, karena kita akan memeriksa keberadaan QR code
            // Mungkin ada validasi tambahan terkait pemindaian aktif
        ]);

        // Cek apakah kode kupon sudah ada dalam database
        $existingRecord = PencatatanKuponMakan::where('kupon_code', $request->kupon_code)->exists();

        if ($existingRecord) {
            return response()->json(['success' => false, 'error' => 'Kupon sudah digunakan sebelumnya.'], 422);
        } else {
            // QR code terdeteksi, simpan pencatatan kupon makan
            PencatatanKuponMakan::create([
                'kupon_code' => $request->kupon_code,
                'scan_method' => 'Nonaktif',
                'scan_time' => now(),
            ]);

            return response()->json(['success' => true, 'message' => 'Pencatatan kupon makan berhasil disimpan.']);
        }
    }



    public function showRekap()
    {
        // Ambil data dari database untuk hari ini
        $laporanRekap = PencatatanKuponMakan::whereDate('scan_time', today())->get();

        // Kirim data ke view untuk ditampilkan
        return view('rekap', ['laporanRekap' => $laporanRekap]);
    }


    public function showLaporanRekap()
    {
        // Ambil tanggal dari form input atau gunakan tanggal hari ini
        $tanggalAwal = request()->input('tanggal_awal', now()->toDateString());
        $tanggalAkhir = request()->input('tanggal_akhir', now()->toDateString());

        // Ambil data dari database berdasarkan rentang tanggal
        $laporanRekap = PencatatanKuponMakan::whereDate('scan_time', '>=', $tanggalAwal)
            ->whereDate('scan_time', '<=', $tanggalAkhir)
            ->get();

        // Kirim data ke view untuk ditampilkan
        return view('rekap', ['laporanRekap' => $laporanRekap]);
    }
}
