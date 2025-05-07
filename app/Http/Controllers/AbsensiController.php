<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Pegawai;
use App\Models\Penilaian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

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

        $jam_checkin_awal  = Carbon::createFromTime(12, 0, 0);
        $jam_checkin_akhir = Carbon::createFromTime(12, 30, 0);

        $status = $now->between($jam_checkin_awal, $jam_checkin_akhir) ? 'Tepat Waktu' : 'Terlambat';
        $absensi->keterangan = $status;

        $penilaian->poin += ($status === 'Tepat Waktu') ? 10 : -5;
    }

    // ==== CHECKOUT ====
    if ($validated['tipe'] === 'checkout' && is_null($absensi->checkout)) {
        $jam_checkout        = Carbon::parse($now);
        $batas_checkout_awal = Carbon::createFromTime(13, 0, 0);
        $batas_checkout_akhir= Carbon::createFromTime(13, 30, 0);
        $batas_jam_normal    = Carbon::createFromTime(13, 0, 0);

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
            } else {
                return response()->json([
                    'message' => 'Checkout hanya bisa dilakukan antara jam 12:00 dan 13:00.'
                ], 400);
            }
        }
    }

    $absensi->save();
    $penilaian->save();

    return response()->json([
        'message'   => 'Absensi berhasil dicatat.',
        'absensi'   => $absensi,
        'penilaian' => $penilaian
    ]);
}







// public function edit(string $id)
//     {
//      $title='Dashboard/Edit-jam-kerja';   
//         $data = Absensi::findorfail($id);
//         return view('dashboard.edit-jamkerja', compact('data','title'));
//     }

    
//     public function update(Request $request, Absensi $absensi)
//     {
//          // dd($request->all());
//        $rules = [
//              'jam_kerja' => 'required|in:normal,lembur'
//         ];

//         $validatedData = $request->validate($rules);

//         Absensi::where('id', $absensi->id)->update($validatedData);
//         if ($validatedData) {
//         Alert::success('Success', 'Berhasil Memperbarui Jam Kerja!');
//         return redirect()->route('data-absensi');
//         } else {
//         Alert::error('error','Anda Gagal Memperbarui Jam Kerja!');
//         return redirect()->route('data-kategori');
//         }
//     }


    

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
