<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JanjiPeriksa extends Model
{
    use HasFactory;
    protected $fillable = [
      'id_pasien', 'id_jadwal_periksa', 'keluhan', 'no_antrian'  
    ];
}
