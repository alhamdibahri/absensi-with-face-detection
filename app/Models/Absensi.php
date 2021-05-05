<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absen';

    protected $fillable = [
        'tanggal_absen',
        'waktu_datang',
        'waktu_pulang',
        'status',
        'foto_absen',
        'jam_kerja_id',
        'karyawan_id'
    ];
}
