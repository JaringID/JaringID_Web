<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Farm;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use App\Models\CatatPakanHarian;

class ActivityController extends Controller
{
    /**
     * Melihat data catat pakan terbaru dari semua tambak yang dimiliki user yang sedang login
     */
    public function getLatestPakanHarian(Request $request)
    {
        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Validasi jika user tidak ditemukan (opsional jika menggunakan auth middleware)
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated.'
            ], 401);
        }

        // Ambil semua tambak (farms) yang dimiliki oleh user
        $farms = Farm::where('user_id', $user->id)->pluck('id');

        // Jika user tidak memiliki tambak, return response kosong
        if ($farms->isEmpty()) {
            return response()->json([
                'message' => 'No farms found for the user.',
                'data' => []
            ], 404);
        }

        // Ambil data catat pakan terbaru untuk setiap tambak
        $latestPakanHarian = CatatPakanHarian::whereIn('farms_id', $farms)
            ->orderBy('tanggal', 'desc') // Urutkan berdasarkan tanggal terbaru
            ->get()
            ->groupBy('farms_id') // Kelompokkan berdasarkan tambak
            ->map(fn($group) => $group->first()); // Ambil data pertama dari setiap tambak (terbaru)

        // Konversi data menjadi array untuk response JSON
        $data = $latestPakanHarian->values()->map(function ($catatPakan) {
            return [
                'id' => $catatPakan->id,
                'farms_id' => $catatPakan->farms_id,
                'kolam_id' => $catatPakan->kolam_id,
                'jadwal_pertama' => $catatPakan->jadwal_pertama,
                'jumlah_pakan_pertama' => $catatPakan->jumlah_pakan_pertama,
                'jadwal_kedua' => $catatPakan->jadwal_kedua,
                'jumlah_pakan_kedua' => $catatPakan->jumlah_pakan_kedua,
                'jadwal_ketiga' => $catatPakan->jadwal_ketiga,
                'jumlah_pakan_ketiga' => $catatPakan->jumlah_pakan_ketiga,
                'jadwal_keempat' => $catatPakan->jadwal_keempat,
                'jumlah_pakan_keempat' => $catatPakan->jumlah_pakan_keempat,
                'jadwal_kelima' => $catatPakan->jadwal_kelima,
                'jumlah_pakan_kelima' => $catatPakan->jumlah_pakan_kelima,
                'tanggal' => $catatPakan->tanggal,
                'created_at' => $catatPakan->created_at,
                'updated_at' => $catatPakan->updated_at,
            ];
        });

        // Jika tidak ada data catat pakan
        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'No feeding data found for the user\'s farms.',
                'data' => []
            ], 404);
        }

        // Return response JSON
        return response()->json([
            'message' => 'Latest feeding data retrieved successfully.',
            'data' => $data
        ], 200);
    }

    /**
     * Melihat histori transaksi pendapatan dan pengeluaran dari semua tambak yang dimiliki user yang sedang login
     */
    public function getTransactionHistory(Request $request)
    {
        try {
            // Validasi user yang sedang login
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated.'
                ], 401);
            }

            // Ambil ID farms yang dimiliki user
            $farms = Farm::where('user_id', $user->id)->pluck('id');
            if ($farms->isEmpty()) {
                return response()->json([
                    'message' => 'No farms found for the user.',
                    'data' => [
                        'pendapatan' => [],
                        'pengeluaran' => []
                    ]
                ], 404);
            }

            // Ambil data pendapatan dengan transformasi
            $pendapatan = Pendapatan::whereIn('farms_id', $farms)
                ->orderBy('tanggal', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'farms_id' => $item->farms_id,
                        'jumlah_pendapatan' => (float) $item->pendapatan,
                        'tanggal' => $item->tanggal,
                    ];
                });

            // Ambil data pengeluaran dengan transformasi
            $pengeluaran = Pengeluaran::whereIn('farms_id', $farms)
                ->orderBy('tanggal', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'farms_id' => $item->farms_id,
                        'jenis_transaksi' => $item->jenis_pengeluaran,
                        'jumlah_pengeluaran' => (float) $item->jumlah_pengeluaran,
                        'tanggal' => $item->tanggal,
                    ];
                });

            // Persiapkan response data
            $responseData = [
                'message' => 'Transaction history retrieved successfully.',
                'data' => [
                    'pendapatan' => $pendapatan->values(),
                    'pengeluaran' => $pengeluaran->values()
                ]
            ];

            // Cek apakah ada data transaksi
            if ($pendapatan->isEmpty() && $pengeluaran->isEmpty()) {
                return response()->json([
                    'message' => 'No transaction data found for the user\'s farms.',
                    'data' => [
                        'pendapatan' => [],
                        'pengeluaran' => []
                    ]
                ], 404);
            }

            return response()->json($responseData, 200);
        } catch (\Exception $e) {
            // Return error message tanpa logging
            return response()->json([
                'message' => 'An error occurred while retrieving transaction history.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
