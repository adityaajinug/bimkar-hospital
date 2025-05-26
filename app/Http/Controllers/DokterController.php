<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DokterController extends Controller
{
    public function index()
    {
        return view('dokter.index', [
            'data' => Dokter::all(),
        ]);
    }

    public function create()
    {
        return view('dokter.form', [
            'action' => 'store',
            'data' => null,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'alamat' => 'required|string|max:500',
                'no_hp' => 'required|string|max:15',
            ]);

            Dokter::create($validatedData);

            return redirect()->route('dokter.index')->with([
                'status' => 'success',
                'message' => 'Dokter berhasil ditambahkan!'
            ]);

        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage()]);

            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Gagal menambahkan dokter! Silakan coba lagi.'
            ]);
        }
    }

    public function edit($id)
    {
        $dokter = Dokter::findOrFail($id);

        return view('dokter.form', [
            'action' => 'update',
            'data' => $dokter,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $dokter = Dokter::findOrFail($id);

            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'alamat' => 'required|string|max:500',
                'no_hp' => 'required|string|max:15',
            ]);

            $dokter->update($validatedData);

            return redirect()->route('dokter.index')->with([
                'status' => 'success',
                'message' => 'Dokter berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage()]);

            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Gagal memperbarui dokter! Silakan coba lagi.'
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $dokter = Dokter::findOrFail($id);

            $dokter->delete();

            return redirect()->route('dokter.index')->with([
                'status' => 'success',
                'message' => 'Dokter berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage()]);

            return redirect()->route('dokter.index')->with([
                'status' => 'error',
                'message' => 'Gagal menghapus dokter! Silakan coba lagi.'
            ]);
        }
    }
}
