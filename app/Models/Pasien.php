<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'nama', 'alamat', 'no_hp'
    ];

    public function dokters()
    {
        return $this->belongsToMany(Dokter::class, 'periksas', 'id_pasien', 'id_dokter');
    }
}
