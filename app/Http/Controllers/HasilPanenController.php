<?php

namespace App\Http\Controllers;

use App\Models\Kolam;
use App\Models\Siklus;
use App\Models\HasilPanen;
use Illuminate\Http\Request;

class HasilPanenController extends Controller
{
    /**
     * Simpan data hasil panen.
     */
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'farms_id' => 'required|integer',
            'kolams_id' => 'required|integer',
            'siklus_id' => 'required|integer',
            'tanggal_panen' => 'required|date',
            'jenis_panen' => 'required|string|in:Total,Parsial,Gagal',
            'total_berat' => 'required|numeric',
            'harga_per_kg' => 'required|numeric',
            'total_harga' => 'required|numeric',
            'pembeli' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        // Simpan data ke dalam database
        $hasilPanen = HasilPanen::create($validatedData);

        // Return response ke client
        return response()->json([
            'success' => true,
            'message' => 'Hasil panen berhasil disimpan.',
            'data' => $hasilPanen,
        ], 201);
    }
    
}
