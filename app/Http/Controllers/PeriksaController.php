<?php

namespace App\Http\Controllers;

use App\Models\Periksa;
use App\Models\Pasien;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PeriksaController extends Controller
{
    public function index()
    {
        return view('periksa.index', [
            'data' => Periksa::all(),
        ]);
    }

    public function create()
    {
        $pasiens = Pasien::all();
        $dokters = Dokter::all();

        return view('periksa.form', [
            'pasiens' => $pasiens,
            'dokters' => $dokters,
            'action' => 'store',
            'data' => null
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_pasien' => 'required|exists:pasiens,id',
                'id_dokter' => 'required|exists:dokters,id',
                'tgl_periksa' => 'required',
                'catatan' => 'nullable|string',
                'obat' => 'nullable|string',
            ]);

            Periksa::create([
                'id_pasien' => $validated['id_pasien'],
                'id_dokter' => $validated['id_dokter'],
                'tgl_periksa' => $validated['tgl_periksa'],
                'catatan' => $validated['catatan'],
                'obat' => $validated['obat'],
            ]);

            return redirect()->route('periksa.index')->with([
                'status' => 'success',
                'message' => 'Periksa berhasil ditambahkan!'
            ]);

        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage()]);

            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Gagal menambahkan Periksa! Silakan coba lagi.'
            ]);
        }
    }

    public function edit($id)
    {
        $periksa = Periksa::findOrFail($id);
        $pasiens = Pasien::all();
        $dokters = Dokter::all();

        return view('periksa.form', [
            'data' => $periksa,
            'pasiens' => $pasiens,
            'dokters' => $dokters,
            'action' => 'update'
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $periksa = Periksa::findOrFail($id);

            $validated = $request->validate([
                'id_pasien' => 'required|exists:pasiens,id',
                'id_dokter' => 'required|exists:dokters,id',
                'tgl_periksa' => 'required|date',
                'catatan' => 'nullable|string',
                'obat' => 'nullable|string',
            ]);

            $periksa->update([
                'id_pasien' => $validated['id_pasien'],
                'id_dokter' => $validated['id_dokter'],
                'tgl_periksa' => $validated['tgl_periksa'],
                'catatan' => $validated['catatan'],
                'obat' => $validated['obat'],
            ]);

            return redirect()->route('periksa.index')->with([
                'status' => 'success',
                'message' => 'Periksa berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage()]);

            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Gagal memperbarui Periksa! Silakan coba lagi.'
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $periksa = Periksa::findOrFail($id);
            $periksa->delete();

            return redirect()->route('periksa.index')->with([
                'status' => 'success',
                'message' => 'Periksa berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage()]);

            return redirect()->route('periksa.index')->with([
                'status' => 'error',
                'message' => 'Gagal menghapus Periksa! Silakan coba lagi.'
            ]);
        }
    }
}