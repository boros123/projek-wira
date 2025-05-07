<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
         $table->id();
            $table->foreignId('jabatan_id');
            $table->string('nama_pegawai');
            $table->string('nip')->unique();
            $table->string('no_telp');
            $table->string('foto_pegawai')->nullable();
            $table->text('alamat');
            $table->enum('jam_kerja',['normal','lembur'])->default('normal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawais');
    }
};
