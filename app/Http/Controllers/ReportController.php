<?php
namespace App\Http\Controllers;

use App\Models\MonthlyReport;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Menampilkan daftar laporan.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $reports = MonthlyReport::all(); // Ambil semua laporan

        return response()->json([
            'message' => 'Daftar laporan berhasil diambil',
            'reports' => $reports,
        ], 200);
    }

    /**
     * Menyimpan laporan baru.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validasi data yang dikirimkan dari aplikasi
        $validated = $request->validate([
            'farms_id' => 'required|integer',
            'kolams_id' => 'required|integer',
            'siklus_id' => 'required|integer',
            'hasil_panens_id' => 'required|integer',
            'catat_pakan_harian_id' => 'required|integer',
            'report_month' => 'required|date',
            'details' => 'nullable|string',
        ]);

        // Simpan data ke database
        $report = MonthlyReport::create($validated);

        // Kembalikan respons berhasil
        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil disimpan',
            'data' => $report
        ], 201);
    }
}
