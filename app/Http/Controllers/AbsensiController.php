<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Pegawai;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AbsensiController extends Controller
{
public function storeabsen(Request $request)
{
    $validated = $request->validate([
        'pegawai_id' => 'required|exists:pegawais,id',
        'tipe'       => 'required|in:checkin,checkout',
    ]);

    $now     = Carbon::now();
    $tanggal = $now->toDateString();

    $absensi = Absensi::firstOrNew([
        'pegawai_id' => $validated['pegawai_id'],
        'tanggal'    => $tanggal,
    ]);

    $penilaian = Penilaian::firstOrNew([
        'pegawai_id' => $validated['pegawai_id'],
        'tanggal'    => $tanggal,
    ]);

    $pegawai = Pegawai::findOrFail($validated['pegawai_id']);

    // ==== CHECKIN ====
    if ($validated['tipe'] === 'checkin' && is_null($absensi->checkin)) {
        $absensi->checkin = $now;

        $jam_checkin_awal  = Carbon::createFromTime(10, 0, 0);
        $jam_checkin_akhir = Carbon::createFromTime(10, 40, 0);

        $status = $now->between($jam_checkin_awal, $jam_checkin_akhir) ? 'Tepat Waktu' : 'Terlambat';
        $absensi->keterangan = $status;

        $penilaian->poin += ($status === 'Tepat Waktu') ? 10 : -5;
    }

   if ($validated['tipe'] === 'checkout' && is_null($absensi->checkout)) {

    $jam_checkout        = Carbon::parse($now);
    $batas_checkout_awal = Carbon::createFromTime(12, 0, 0);
    $batas_checkout_akhir= Carbon::createFromTime(12, 50, 0);
    $batas_jam_normal    = Carbon::createFromTime(12, 50, 0);

    // Kalau belum checkin
    if (is_null($absensi->checkin)) {
        $absensi->checkout  = $now;
        $absensi->status    = 'Tidak Hadir';
        $absensi->keterangan= 'Tidak Check-in';
    } 
    else {
        if ($pegawai->jam_kerja === 'lembur') {
            $absensi->checkout = $now;
            $absensi->status   = 'Hadir';
            $penilaian->poin  += 5;

            if ($jam_checkout->gt($batas_jam_normal)) {
                $durasi_lembur_menit = $jam_checkout->diffInMinutes($batas_jam_normal);
                $durasi_lembur_jam   = $durasi_lembur_menit / 60;
                $poin_lembur         = $durasi_lembur_jam * 5;

                $penilaian->poin_lembur += $poin_lembur;
            }

        } else {
            if ($jam_checkout->between($batas_checkout_awal, $batas_checkout_akhir)) {
                $absensi->checkout = $now;
                $absensi->status   = 'Hadir';
                $penilaian->poin  += 5;
            } 
        }
    }
}

    $absensi->save();
    $penilaian->save();

    return response()->json();
}









    

public function fetchdataabsen(){
  $absensis = Absensi::orderBy('created_at', 'desc')->get();
    return view('components.table-absensi', compact('absensis'));

}

public function index(){
    $absensis = Absensi::all();
    return view('Dashboard.data-absensi', [
        'absensis' => $absensis,
        'title' => 'Dashboard/Data Absensi'
    ]);

}

}
