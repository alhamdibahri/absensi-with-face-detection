<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absen', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('jam_kerja_id');
            $table->bigInteger('karyawan_id');
            $table->date('tanggal_absen');
            $table->time('waktu_datang')->nullable();
            $table->time('waktu_pulang')->nullable();
            $table->enum('status', ['TERLAMBAT', 'TEPAT_WAKTU']);
            $table->string('foto_absen')->nullable();
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
        Schema::dropIfExists('absen');
    }
}
