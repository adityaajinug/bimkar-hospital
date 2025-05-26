<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PasienController extends Controller
{
    public function index()
    {
        return view('pasien.index', [
            'data' => Pasien::all(),
        ]);
    }

    public function create()
    {
        return view('pasien.form', [
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

            Pasien::create($validatedData);

            return redirect()->route('pasien.index')->with([
                'status' => 'success',
                'message' => 'Pasien berhasil ditambahkan!'
            ]);

        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage()]);

            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Gagal menambahkan pasien! Silakan coba lagi.'
            ]);
        }
    }

    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);

        return view('pasien.form', [
            'action' => 'update',
            'data' => $pasien,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $pasien = Pasien::findOrFail($id);

            $validatedData = $request->validate([
                'nama' => 'required|string|max:255',
                'alamat' => 'required|string|max:500',
                'no_hp' => 'required|string|max:15',
            ]);

            $pasien->update($validatedData);

            return redirect()->route('pasien.index')->with([
                'status' => 'success',
                'message' => 'Pasien berhasil diperbarui!'
            ]);

        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage()]);

            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Gagal memperbarui pasien! Silakan coba lagi.'
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $pasien = Pasien::findOrFail($id);

            $pasien->delete();

            return redirect()->route('pasien.index')->with([
                'status' => 'success',
                'message' => 'Pasien berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage()]);

            return redirect()->route('pasien.index')->with([
                'status' => 'error',
                'message' => 'Gagal menghapus pasien! Silakan coba lagi.'
            ]);
        }
    }
}
