<?php

namespace App\Models;

use App\Models\Absensi;
use App\Models\Jabatan;
use App\Models\Penilaian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;
     protected $table = 'pegawais';
    protected $guarded = ['id'];

     public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }


    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

      public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }
}
