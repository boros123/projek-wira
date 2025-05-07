<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index(){
        $penilaians = Penilaian::all();
        $title='home/data-penilaian';
        // $total_poin=$penilaian->poin + $penilaian->poin_lembur; 
        return view('dashboard.data-penilaian',compact('penilaians','title'));
    }
}
