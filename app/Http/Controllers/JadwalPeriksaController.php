<?php

namespace App\Http\Controllers;

use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JadwalPeriksaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $data = JadwalPeriksa::all();
        } catch(\Exception $e) {
            Log::error(['error' => $e->getMessage()]);
        }

        
        return view('dokter.jadwal', ['data' => $data]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(JadwalPeriksa $jadwalPeriksa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalPeriksa $jadwalPeriksa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {

        try {
            $jadwalPeriksa = JadwalPeriksa::findOrFail($id); 

            if (!$jadwalPeriksa->status) { 
                JadwalPeriksa::where('id_dokter', $jadwalPeriksa->id_dokter)->update(['status' => false]); 

                $jadwalPeriksa->status = true; 

            } else {
                $jadwalPeriksa->status = false; 
            }

            $jadwalPeriksa->save(); 
    

        } catch (\Exception $e) {
            Log::error(['error' => $e->getMessage()]);
        }

        return redirect()->back()->with([
            'status' => 'success', 
            'message' => 'Status Updated'
        ]); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalPeriksa $jadwalPeriksa)
    {
        //
    }
}
