<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = [
        'nip',
        'nama_karyawan',
        'tempat_lahir',
        'tanggal_lahir',
        'no_telp',
        'jenis_kelamin',
        'agama',
        'foto_karyawan',
    ];
}
