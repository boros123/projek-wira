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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id');
            $table->date('tanggal');
            $table->timestamp('checkin')->nullable();
            $table->timestamp('checkout')->nullable();
            $table->enum('status', ['Hadir', 'Izin', 'Tidak Hadir'])->default('Tidak Hadir');
          $table->string('keterangan')->nullable();
            $table->unique(['pegawai_id', 'tanggal']);
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
        Schema::dropIfExists('absensis');
    }
};
