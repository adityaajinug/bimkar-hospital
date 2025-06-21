<?php

namespace App\Http\Controllers;

use App\Models\JanjiPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function pasien()
    {
        $no_rm = Auth::user()->no_rm;
        $janjiPeriksas = JanjiPeriksa::with(['jadwalPeriksa.dokter', 'periksa.detailPeriksas.obat'])
            ->where('id_pasien', Auth::user()->id)
            ->whereDoesntHave('periksa')
            ->get();

        return view('pasien.dashboard')->with([
            'no_rm' => $no_rm,
            'data' => $janjiPeriksas,
        ]);
    }
}
