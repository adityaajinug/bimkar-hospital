<?php

namespace App\Http\Controllers;

use App\Models\DetailPeriksa;
use App\Models\JadwalPeriksa;
use App\Models\JanjiPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MemeriksaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwalPeriksa = JadwalPeriksa::where('id_dokter', Auth::user()->id)
            ->where('status', true)
            ->first();
        $janjiPeriksas = JanjiPeriksa::where('id_jadwal_periksa', $jadwalPeriksa->id)
            ->with(['pasien', 'jadwalPeriksa'])
            ->get();
        $obats = Obat::all();
        return view('dokter.memeriksa')->with([
            'data' => $janjiPeriksas,
            'obats' => $obats,
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
    public function store(Request $request, $id)
    {
        try {
            $request->validate([
                'tgl_periksa' => 'required|date',
                'catatan' => 'required|string',
                'obat' => 'required|array|min:1',
                'obat.*' => 'exists:obats,id',
                'biaya_periksa' => 'required|numeric',
            ]);

            $janjiPeriksa = JanjiPeriksa::findOrFail($id);

            $periksa = Periksa::create([
                'id_janji_periksa' => $janjiPeriksa->id,
                'tgl_periksa' => $request->tgl_periksa,
                'catatan' => $request->catatan,
                'biaya_periksa' => $request->biaya_periksa,
            ]);

            foreach ($request->obat as $obatId) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $obatId,
                ]);
            }

            return redirect()
                ->route('memeriksa.index')
                ->with([
                    'status' => 'success',
                    'message' => 'Pasien telah diperiksa',
                ]);
        } catch (\Exception $e) {
            Log::error('Gagal memproses pemeriksaan pasien: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->withErrors([
                    'error' => 'Terjadi kesalahan saat menyimpan data pemeriksaan. Silakan coba lagi.',
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function periksa(int $id)
    {
        $janjiPeriksa = JanjiPeriksa::with('pasien')->findOrFail($id);
        $obats = Obat::all();

        return view('dokter.periksa-pasien')->with([
            'data' => $janjiPeriksa,
            'obats' => $obats,
            'action' => 'store'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $janjiPeriksa = JanjiPeriksa::with(['pasien', 'periksa.detailPeriksas'])->findOrFail($id);
        $obats = Obat::all();
        return view('dokter.periksa-pasien')->with([
            'data' => $janjiPeriksa,
            'obats' => $obats,
            'action' => 'update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'tgl_periksa' => 'required|date',
            'catatan' => 'required|string',
            'obat' => 'required|array|min:1',
            'obat.*' => 'exists:obats,id',
            'biaya_periksa' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $periksa = Periksa::findOrFail($id);

            $periksa->update([
                'tgl_periksa' => $request->tgl_periksa,
                'catatan' => $request->catatan,
                'biaya_periksa' => $request->biaya_periksa,
            ]);

            $periksa->detailPeriksas()->delete();

            foreach ($request->obat as $obatId) {
                $periksa->detailPeriksas()->create([
                    'id_obat' => $obatId,
                ]);
            }

            DB::commit();

            return redirect()->route('memeriksa.index')->with([
                'status' => 'success',
                'message' => 'Periksa telah diupdate'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal update pemeriksaan: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
