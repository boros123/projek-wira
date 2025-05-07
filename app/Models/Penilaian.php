<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;
        protected $table = 'penilaians';
    protected $guarded = ['id'];

      public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
