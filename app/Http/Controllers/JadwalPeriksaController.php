<?php

namespace App\Http\Controllers;

use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $status = null;
        $message = null;

        try {
            $request->validate([
                'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
                'jam_mulai' => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            ]);

            $exists = JadwalPeriksa::where('id_dokter', Auth::user()->id)
                ->where('hari', $request->hari)
                ->where('jam_mulai', $request->jam_mulai)
                ->where('jam_selesai', $request->jam_selesai)
                ->exists();

            if ($exists) {
                $status = 'error';
                $message = 'Jadwal tersebut sudah terdaftar.';
            } else {
                JadwalPeriksa::create([
                    'id_dokter' => Auth::user()->id,
                    'hari' => $request->hari,
                    'jam_mulai' => $request->jam_mulai,
                    'jam_selesai' => $request->jam_selesai,
                    'status' => false,
                ]);

                $status = 'success';
                $message = 'Jadwal berhasil ditambahkan.';
            }

        } catch (\Exception $e) {
            Log::error('error: ' . $e->getMessage());
            $status = 'error';
            $message = 'Terjadi kesalahan saat menyimpan jadwal.';
        }

        return redirect()->back()->with([
            'status' => $status,
            'message' => $message,
        ]);
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
