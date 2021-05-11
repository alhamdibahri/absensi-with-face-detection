<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 50)->unique();
            $table->string('nama_karyawan', 50);
            $table->text('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('no_telp')->unique();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan'])->default('Laki-Laki');
            $table->enum('agama', ['Islam', 'Kristen', 'Hindu', 'Budha', 'Katolik', 'Konghucu'])->default('Islam');
            $table->string('foto_karyawan');
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
        Schema::dropIfExists('karyawan');
    }
}
