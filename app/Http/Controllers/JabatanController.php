<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class JabatanController extends Controller
{
   public function index() {
     
        return view('dashboard.data-jabatan',[
         "jabatans" => Jabatan::all(),
         "title"=>'Dashboard/data-jabatan'
        ]);
   }

   public function store(Request $request){
      $data = $request->validate([
            'nama_jabatan' => 'required|unique:jabatans,nama_jabatan',
            'deskripsi' => 'required',
        ]);
        $existingData = Jabatan::where('nama_jabatan', $data['nama_jabatan'])->first();
        if ($existingData) {
         Alert::error('Error','Data Tidak Boleh Sama');
        return back();
        }

        $data['tanggal'] = Carbon::now();    
        
        Jabatan::create($data);
        Alert::success('Success', 'Berhasil Membuat Data!');
        return back();
   }


   public function update() {
   
   
   }


   public function show() {
   
   
   }

   public function destroy() {
   
   
   }
}
