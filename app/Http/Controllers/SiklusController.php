<?php

namespace App\Http\Controllers;

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
}
