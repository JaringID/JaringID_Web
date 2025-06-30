<?php

namespace App\Http\Controllers;

use App\Models\CatatPakanHarian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PemberianPakanController extends Controller
{
    /**
     * Mencatat pemberian pakan harian per jam.
     */
    public function catatPakanHarian(Request $request)
    {
        $request->validate([
            'farms_id'     => 'required|exists:farms,id',
            'kolam_id'     => 'required|exists:kolams,id',
            'jam_pakan'    => 'required|date_format:H:i',
            'jumlah_pakan' => 'required|numeric|min:0',
            'tanggal'      => 'required|date_format:d/m/Y',
        ]);

        try {
            $tanggal = Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Format tanggal tidak valid. Gunakan DD/MM/YYYY.'], 400);
        }

        // Cari data untuk hari & kolam yang sama
        $catatPakan = CatatPakanHarian::firstOrNew([
            'farms_id' => $request->farms_id,
            'kolam_id' => $request->kolam_id,
            'tanggal'  => $tanggal,
        ]);

        $urutan = [
            'pertama' => ['jadwal_pertama', 'jumlah_pakan_pertama'],
            'kedua'   => ['jadwal_kedua', 'jumlah_pakan_kedua'],
            'ketiga'  => ['jadwal_ketiga', 'jumlah_pakan_ketiga'],
            'keempat' => ['jadwal_keempat', 'jumlah_pakan_keempat'],
            'kelima'  => ['jadwal_kelima', 'jumlah_pakan_kelima'],
        ];

        // Cari slot kosong yang pertama
        foreach ($urutan as $slot => [$jamKey, $jumlahKey]) {
            if (empty($catatPakan->$jamKey)) {
                $catatPakan->$jamKey    = $request->jam_pakan;
                $catatPakan->$jumlahKey = $request->jumlah_pakan;
                $catatPakan->save();

                return response()->json([
                    'message' => "Pakan ke-$slot berhasil dicatat.",
                    'data'    => $catatPakan,
                ]);
            }
        }

        return response()->json([
            'message' => 'Semua jadwal pakan sudah terisi untuk hari ini.',
        ], 400);
    }

    /**
     * Mengambil data pemberian pakan untuk kolam dan tanggal tertentu.
     */
    public function getCatatPakan(Request $request)
    {
        $request->validate([
            'farms_id' => 'required|exists:farms,id',
            'kolam_id' => 'required|exists:kolams,id',
            'tanggal'  => 'required|date_format:d/m/Y',
        ]);

        try {
            $tanggal = Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Format tanggal tidak valid. Gunakan DD/MM/YYYY.'], 400);
        }

        $catatPakan = CatatPakanHarian::where('farms_id', $request->farms_id)
            ->where('kolam_id', $request->kolam_id)
            ->where('tanggal', $tanggal)
            ->first();

        if (!$catatPakan) {
            return response()->json([
                'message' => 'Data pemberian pakan tidak ditemukan.',
                'data'    => null,
            ], 404);
        }

        return response()->json([
            'message'         => 'Data ditemukan.',
            'id'              => $catatPakan->id,
            'farms_id'        => $catatPakan->farms_id,
            'kolam_id'        => $catatPakan->kolam_id,
            'tanggal'         => $catatPakan->tanggal,
            'jam_pakan'       => $catatPakan->jadwal_pertama ?? '',
            'jumlah_pakan'    => $catatPakan->jumlah_pakan_pertama ?? 0,
            'data'            => $catatPakan,
        ]);
    }
}
