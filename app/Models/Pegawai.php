<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
