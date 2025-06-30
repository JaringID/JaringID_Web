<?php

namespace App\Http\Controllers;

use App\Models\HasilPanen;
use App\Models\Pendapatan;
use Illuminate\Http\Request;

class HasilPanenController extends Controller
{
    /**
     * Menyimpan data hasil panen dan memperbarui pendapatan.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi data input
        $validated = $request->validate([
            'farms_id'      => 'required|integer',
            'kolams_id'     => 'required|integer',
            'siklus_id'     => 'required|integer',
            'tanggal_panen' => 'required|date',
            'jenis_panen'   => 'required|in:Total,Parsial,Gagal',
            'total_berat'   => 'required|numeric',
            'harga_per_kg'  => 'required|numeric',
            'total_harga'   => 'required|numeric',
            'pembeli'       => 'nullable|string',
            'catatan'       => 'nullable|string',
        ]);

        // Simpan hasil panen
        $hasilPanen = HasilPanen::create($validated);

        // Cek atau buat pendapatan harian
        $pendapatan = Pendapatan::firstOrCreate(
            [
                'farms_id' => $validated['farms_id'],
                'tanggal'  => $validated['tanggal_panen'],
            ],
            [
                'saldo' => 0,
                'pendapatan' => 0,
            ]
        );

        // Tambahkan nominal ke pendapatan dan saldo
        $pendapatan->increment('pendapatan', $validated['total_harga']);
        $pendapatan->increment('saldo', $validated['total_harga']);

        // Kirim respon ke client
        return response()->json([
            'success' => true,
            'message' => 'Hasil panen berhasil disimpan & pendapatan diperbarui.',
            'data' => $hasilPanen,
        ], 201);
    }
}
