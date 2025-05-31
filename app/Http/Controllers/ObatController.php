<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Obat::all();
        } catch(\Exception $e) {
            Log::error(['error' => $e->getMessage()]);
        }

        
        return view('obat.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('obat.form', [
            'action' => 'store',
            'data' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_obat' => 'required|string|max:255',
                'kemasan' => 'required|string|max:500',
                'harga' => 'required|string|max:15',
            ]);

            Obat::create($validatedData);

        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage()]);
        }

        return redirect()->route('obat.index')->with([
            'status' => 'success',
            'message' => 'Obat berhasil ditambahkan!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Obat $obat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $obat = Obat::findOrFail($id);
        } catch(\Exception $e) {
            Log::error(['error' => $e->getMessage()]);
        }

        return view('obat.form', [
            'action' => 'update',
            'data' => $obat,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $obat = Obat::findOrFail($id);

            $validatedData = $request->validate([
                'nama_obat' => 'required|string|max:255',
                'kemasan' => 'required|string|max:500',
                'harga' => 'required',
            ]);

            $obat->update($validatedData);

        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage()]);
        }

        return redirect()->route('obat.index')->with([
            'status' => 'success',
            'message' => 'Obat berhasil diperbarui!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $obat = Obat::findOrFail($id);
            $obat->delete();

        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage()]);
        }

         return redirect()->route('obat.index')->with([
            'status' => 'success',
            'message' => 'Obat berhasil dihapus!'
        ]);
    }
}
