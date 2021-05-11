<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JamKerja extends Model
{
    use HasFactory;

    protected $table = 'jam_kerja';

    protected $fillable =[
        'hari', 
        'masuk_kerja',
        'pulang_kerja',
        'company_id',
        'kondisi'
    ];

}
