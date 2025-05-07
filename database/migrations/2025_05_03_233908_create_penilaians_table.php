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
        Schema::create('penilaians', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pegawai_id')->constrained()->onDelete('cascade');
        $table->date('tanggal');
        $table->integer('poin')->default(0);
        $table->integer('poin_lembur')->default(0);
        $table->timestamps();
        $table->unique(['pegawai_id', 'tanggal']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaians');
    }
};
