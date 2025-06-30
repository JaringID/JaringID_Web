<?php

namespace App\Http\Controllers;

use App\Models\MonthlyReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Menampilkan semua laporan bulanan.
     */
    public function index()
    {
        $reports = MonthlyReport::all();

        return response()->json([
            'message' => 'Daftar laporan berhasil diambil.',
            'reports' => $reports,
        ], 200);
    }

    /**
     * Menyimpan laporan bulanan baru.
     */
    public function store(Request $request)
    {
        // Validasi input dari client
        $validated = $request->validate([
            'farms_id'              => 'required|integer|exists:farms,id',
            'kolams_id'             => 'required|integer|exists:kolams,id',
            'siklus_id'             => 'required|integer|exists:siklus,id',
            'hasil_panens_id'       => 'required|integer|exists:hasil_panens,id',
            'catat_pakan_harian_id' => 'required|integer|exists:catat_pakan_harians,id',
            'report_month'          => 'required|date',
            'details'               => 'nullable|string',
        ]);

        $report = MonthlyReport::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Laporan berhasil disimpan.',
            'data'    => $report,
        ], 201);
    }
}
