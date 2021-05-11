<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnKondisiInJamKerja extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jam_kerja', function (Blueprint $table) {
            $table->enum('kondisi', ['Libur', 'Masuk'])->default('Libur');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jam_kerja', function (Blueprint $table) {
            $table->dropColumn('kondisi');
        });
    }
}
