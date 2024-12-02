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
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Simpan laporan baru
        $report = MonthlyReport::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        return response()->json([
            'message' => 'Laporan berhasil disimpan',
            'report' => $report,
        ], 201);
    }
}
