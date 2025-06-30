<?php

namespace App\Http\Controllers;

use App\Models\Kolam;
use App\Models\Siklus;
use Illuminate\Http\Request;

class SiklusController extends Controller
{
    /**
     * Menyimpan data siklus baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'farm_id'       => 'required|integer|exists:farms,id',
            'kolam_id'      => 'required|integer|exists:kolams,id',
            'total_tebar'   => 'required|integer|min:1',
            'tipe_tebar'    => 'required|string|max:50',
            'tanggal_tebar' => 'required|date',
        ]);

        $siklus = Siklus::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Siklus berhasil dibuat.',
            'data'    => $siklus,
        ], 201);
    }

    /**
     * Menghentikan siklus dan menonaktifkan kolam.
     */
    public function stopSiklus(Request $request)
    {
        $request->validate([
            'kolams_id'  => 'required|exists:kolams,id',
            'siklus_id'  => 'required|exists:siklus,id',
        ]);

        try {
            // Update status siklus menjadi "berhenti"
            $siklus = Siklus::findOrFail($request->siklus_id);
            $siklus->status_siklus = 'berhenti';
            $siklus->save();

            // Update status kolam menjadi "tidak_aktif"
            $kolam = Kolam::findOrFail($request->kolams_id);
            $kolam->status = 'tidak_aktif';
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
