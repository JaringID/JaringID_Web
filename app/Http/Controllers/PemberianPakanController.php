<?php

namespace App\Http\Controllers;

use App\Models\CatatPakanHarian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PemberianPakanController extends Controller
{
    /**
     * Menangani pemberian pakan secara berurutan.
     */
    public function catatPakanHarian(Request $request)
    {
        // Validasi input
        $request->validate([
            'farms_id' => 'required|exists:farms,id',
            'kolam_id' => 'required|exists:kolams,id',
            'jam_pakan' => 'required|date_format:H:i', // Jam pemberian pakan
            'jumlah_pakan' => 'required|numeric|min:0', // Jumlah pakan
            'tanggal' => 'required|date_format:d/m/Y', // Format: DD/MM/YYYY
        ]);

        // Ambil inputan
        $farmsId = $request->farms_id;
        $kolamId = $request->kolam_id;
        $jamPakan = $request->jam_pakan;
        $jumlahPakan = $request->jumlah_pakan;

        // Konversi format tanggal DD/MM/YYYY ke YYYY-MM-DD
        $tanggalInput = $request->tanggal;
        try {
            $tanggal = Carbon::createFromFormat('d/m/Y', $tanggalInput)->format('Y-m-d');
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Format tanggal tidak valid. Gunakan DD/MM/YYYY.'
            ], 400);
        }

        // Cari data yang sudah ada untuk tanggal yang sama
        $catatPakan = CatatPakanHarian::where('farms_id', $farmsId)
            ->where('kolam_id', $kolamId)
            ->where('tanggal', $tanggal)
            ->first();

        if (!$catatPakan) {
            // Jika data tidak ada, buat data baru
            $catatPakan = new CatatPakanHarian();
            $catatPakan->farms_id = $farmsId;
            $catatPakan->kolam_id = $kolamId;
            $catatPakan->tanggal = $tanggal;
        }

        // Tentukan jadwal pemberian pakan berdasarkan jam input user
        if (empty($catatPakan->jadwal_pertama)) {
            $catatPakan->jadwal_pertama = $jamPakan;
            $catatPakan->jumlah_pakan_pertama = $jumlahPakan;
        } elseif (empty($catatPakan->jadwal_kedua)) {
            $catatPakan->jadwal_kedua = $jamPakan;
            $catatPakan->jumlah_pakan_kedua = $jumlahPakan;
        } elseif (empty($catatPakan->jadwal_ketiga)) {
            $catatPakan->jadwal_ketiga = $jamPakan;
            $catatPakan->jumlah_pakan_ketiga = $jumlahPakan;
        } elseif (empty($catatPakan->jadwal_keempat)) {
            $catatPakan->jadwal_keempat = $jamPakan;
            $catatPakan->jumlah_pakan_keempat = $jumlahPakan;
        } elseif (empty($catatPakan->jadwal_kelima)) {
            $catatPakan->jadwal_kelima = $jamPakan;
            $catatPakan->jumlah_pakan_kelima = $jumlahPakan;
        } else {
            return response()->json([
                'message' => 'Semua jadwal pemberian pakan sudah diisi untuk hari ini.'
            ], 400);
        }

        // Simpan data
        $catatPakan->save();

        return response()->json([
            'message' => 'Pemberian pakan berhasil dicatat.',
            'data' => $catatPakan,
        ], 200);
    }
}