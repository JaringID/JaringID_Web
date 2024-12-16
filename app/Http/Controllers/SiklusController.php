<?php

namespace App\Http\Controllers;

use App\Models\Kolam;
use Illuminate\Http\Request;
use App\Models\Siklus;

class SiklusController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang dikirimkan dari aplikasi
        $validated = $request->validate([
            'farm_id' => 'required|integer',
            'kolam_id' => 'required|integer',
            'total_tebar' => 'required|integer',
            'tipe_tebar' => 'required|string',
            'tanggal_tebar' => 'required|date',
        ]);

        // Simpan data ke database
        $siklus = Siklus::create($validated);

        // Kembalikan respons berhasil
        return response()->json([
            'success' => true,
            'message' => 'Siklus berhasil dibuat',
            'data' => $siklus
        ], 201);
    }
    public function stopSiklus(Request $request)
    {
        $request->validate([
            'kolams_id' => 'required|exists:kolams,id',
            'siklus_id' => 'required|exists:siklus,id',
        ]);

        try {
            // Update status siklus
            $siklus = Siklus::findOrFail($request->siklus_id);
            $siklus->status_siklus = 'berhenti'; // Status berhenti
            $siklus->save();

            // Update status kolam
            $kolam = Kolam::findOrFail($request->kolams_id);
            $kolam->status = 'tidak_aktif'; // Kolam tidak aktif
            $kolam->save();

            return response()->json([
                'message' => 'Siklus dihentikan dan kolam dinonaktifkan.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal memperbarui data: ' . $e->getMessage(),
            ], 500);
        }
    }

    
}
