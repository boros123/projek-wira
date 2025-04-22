<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbsensiController extends Controller
{
public function storeabsen(Request $request)
{
    $validated = $request->validate([
        'pegawai_id' => 'required|exists:pegawais,id',
        'tipe' => 'required|in:checkin,checkout',
    ]);

    $now = Carbon::now();
    $tanggal = $now->toDateString();

    $absensi = Absensi::firstOrNew([
        'pegawai_id' => $validated['pegawai_id'],
        'tanggal' => $tanggal,
    ]);

   if ($validated['tipe'] === 'checkin' && is_null($absensi->checkin)) {
    $absensi->checkin = $now;

    $jam_tepat_awal = Carbon::createFromTime(14, 0, 0);
    $jam_tepat_akhir = Carbon::createFromTime(14, 40, 0);

    $absensi->keterangan = ($now->between($jam_tepat_awal, $jam_tepat_akhir->subSecond()))
    ? 'Tepat Waktu' : 'Terlambat';

}

if ($validated['tipe'] === 'checkout' && is_null($absensi->checkout)) {
    $absensi->checkout = $now;
}


if (!is_null($absensi->checkin) && !is_null($absensi->checkout)) {
    $absensi->status = 'Hadir';
}


    // Simpan ke database
    $absensi->save();

    return response()->json([
        'message' => 'Absensi berhasil',
    ]);
}




public function fetchdataabsen(){
  $absensis = Absensi::orderBy('created_at', 'desc')->get();
    return view('components.table-absensi', compact('absensis'));

}

public function index(){
    $absensis = Absensi::orderBy('created_at', 'desc')->get();
    return view('Dashboard.data-absensi', [
        'absensis' => $absensis,
        'title' => 'Dashboard/Data Absensi'
    ]);

}

}
