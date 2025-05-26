<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'nama', 'alamat', 'no_hp'
    ];

    public function pasiens()
    {
        return $this->belongsToMany(Pasien::class, 'periksas', 'id_dokter', 'id_pasien');
    }
}
