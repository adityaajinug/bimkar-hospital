<?php

namespace App\Http\Controllers;

use App\Models\JanjiPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPeriksaController extends Controller
{
    public function index()
    {
        $no_rm = Auth::user()->no_rm;
        $janjiPeriksas = JanjiPeriksa::with(['jadwalPeriksa.dokter', 'periksa.detailPeriksas.obat'])
            ->where('id_pasien', Auth::user()->id)
            ->get();

        // dd($janjiPeriksas);
        return view('pasien.riwayat-periksa')->with([
            'no_rm' => $no_rm,
            'data' => $janjiPeriksas,
        ]);
    }
}
