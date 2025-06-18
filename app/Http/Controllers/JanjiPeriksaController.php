<?php

namespace App\Http\Controllers;

use App\Models\JadwalPeriksa;
use App\Models\JanjiPeriksa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JanjiPeriksaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $no_rm = Auth::user()->no_rm;
        $janjiPeriksas = JanjiPeriksa::where('id_pasien', Auth::user()->id)->get();
        $dokters = User::with([
            'jadwalPeriksas' => function ($query) {
                $query->where('status', true);
            },
        ])
            ->where('role', 'dokter')
            ->get();

        return view('pasien.janji-periksa')->with([
            'no_rm' => $no_rm,
            'dokters' => $dokters,
            'data' => $janjiPeriksas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_dokter' => 'required|exists:users,id',
                'keluhan' => 'required',
            ]);

            // $sudahBuatJanji = JanjiPeriksa::where('id_pasien', Auth::id())
            //     ->whereHas('jadwalPeriksa', function ($query) use ($validated) {
            //         $query->where('id_dokter', $validated['id_dokter']);
            //     })
            //     ->with(['jadwalPeriksa.dokter'])
            //     ->first();

            // if ($sudahBuatJanji) {
            //     return redirect()
            //         ->back()
            //         ->with([
            //             'status' => 'error',
            //             'message' => 'Anda Sudah membuat janji dengan dokter ' . $sudahBuatJanji->jadwalPeriksa->dokter->nama
            //         ])
            //         ->withInput();
            // }

            $jadwalPeriksa = JadwalPeriksa::where('id_dokter', $validated['id_dokter'])->where('status', true)->first();

            // if (!$jadwalPeriksa) {
            //     return redirect()
            //         ->back()
            //         ->withErrors([
            //             'id_dokter' => 'Jadwal periksa untuk dokter ini tidak tersedia.',
            //         ])
            //         ->withInput();
            // }

            $jumlahJanji = JanjiPeriksa::where('id_jadwal_periksa', $jadwalPeriksa->id)->count();
            $noAntrian = $jumlahJanji + 1;

            JanjiPeriksa::create([
                'id_pasien' => Auth::id(),
                'id_jadwal_periksa' => $jadwalPeriksa->id,
                'keluhan' => $validated['keluhan'],
                'no_antrian' => $noAntrian,
            ]);

            return redirect()
                ->route('janji-periksa.index')
                ->with([
                    'status' => 'success',
                    'message' => 'Janji Periksa telah dibuat.',
                ]);
        } catch (\Exception $e) {
            Log::error('Gagal membuat janji periksa: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withErrors([
                    'error' => 'Terjadi kesalahan saat membuat janji periksa. Silakan coba lagi.',
                ])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(JanjiPeriksa $janjiPeriksa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JanjiPeriksa $janjiPeriksa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JanjiPeriksa $janjiPeriksa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JanjiPeriksa $janjiPeriksa)
    {
        //
    }
}
