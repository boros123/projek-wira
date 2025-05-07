<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function index()  {
        // if (Auth::user()->roles === 'Admin') {
        
              return view('dashboard.data-pegawai',[
                "jabatans" => Jabatan::all(),
                "pegawais" => Pegawai::all()->sortByDesc('created_at'),
                'title'=>'Dashboard/Data Pegawai',
                'nip'=> 'PG-' . Str::random(9)
        ]);
        // } else {
        //     Alert::error('error','Maaf anda gapunya akses!');
        //     return back();
        // }
    }

    public function store(Request $request)  {
        $data = $request->validate([
            'jabatan_id' => 'required',
            'nama_pegawai' => 'required|unique:pegawais,nama_pegawai',
            'nip' => 'required|unique:pegawais,nip',
            'no_telp' => 'required|numeric|min:12',
            'foto_pegawai' => 'required|image|file|mimes:jpeg,png,jpg|max:20000',
            'alamat' => 'required|min:20',
        ]);

    
        if ($request->file('foto_pegawai')) {
            $data['foto_pegawai'] = $request->file('foto_pegawai')->store('foto-pegawai');
        }
        
        Pegawai::create($data);
        Alert::success('Success', 'Berhasil Menambahkan Pegawai Baru!');
        return back();
    }



    public function edit(String $id){
        $title='Dashboard/get data pegawai';
        $jabatans = Jabatan::all();
        $data = Pegawai::findorfail($id);
        return view('dashboard.edit-pegawai', compact('data','jabatans','title'));
   

    }
    public function update(Request $request, Pegawai $pegawai)
    {
        // dd($request->all());
       $rules = [
             'jabatan_id' => 'required',
            'nama_pegawai' => 'required|',
            'nip' => 'required',
            'no_telp' => 'required|numeric|min:12',
            'foto_pegawai' => 'image|file|mimes:jpeg,png,jpg|max:20000',
            'alamat' => 'required|min:20',
            'jam_kerja' => 'required',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('foto_pegawai')) {
        if ($request->oldpegawai) {
            Storage::delete($request->oldpegawai);
        }
        $validatedData['foto_pegawai'] = $request->file('foto_pegawai')->store('foto-pegawai');
        }
        Pegawai::where('id', $pegawai->id)->update($validatedData);
        if ($validatedData) {
        Alert::success('Success', 'Berhasil Memperbarui Data Pegawai!');
        return redirect()->route('home');
        } else {
        Alert::error('error','Anda Gagal Memperbarui Data Pegawai!');
        return redirect()->route('data-pegawai');
        }
    }

      public function destroy(string $id)
    {
        $pegawai = Pegawai::find($id);
        Storage::delete(['public/foto-pegawai', $pegawai->foto_pegawai]);
        $pegawai->delete();
        Alert::success('Success', 'Berhasil Menghapus Data Pegawai!');
        return back();
    }











    
    // END POINT API PEGAWAI
    public function endpointpegawai(){
        $pegawai=Pegawai::all();
        return response()->json($pegawai);
    }
}
