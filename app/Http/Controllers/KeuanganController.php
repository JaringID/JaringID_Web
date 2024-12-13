<?php

namespace App\Http\Controllers;

use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use App\Models\LaporanKeuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function catatSaldo(Request $request)
    {
        $request->validate([
            'farms_id' => 'required|exists:farms,id',
            'saldo' => 'required|numeric|min:0',
            'tanggal' => 'required|date_format:d/m/Y',
        ]);

        $tanggal = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');

        $pendapatan = Pendapatan::create([
            'farms_id' => $request->farms_id,
            'saldo' => $request->saldo,
            'tanggal' => $tanggal,
        ]);

        return response()->json([
            'message' => 'Saldo berhasil dicatat.',
            'data' => $pendapatan,
        ], 201);
    }

    public function catatPendapatan(Request $request)
    {
        $request->validate([
            'farms_id' => 'required|exists:farms,id',
            'pendapatan' => 'required|numeric|min:0',
            'tanggal' => 'required|date_format:d/m/Y',
        ]);

        $tanggal = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');

        $lastSaldo = Pendapatan::where('farms_id', $request->farms_id)->latest('tanggal')->value('saldo');
        $updatedSaldo = ($lastSaldo ?? 0) + $request->pendapatan;

        $pendapatan = Pendapatan::create([
            'farms_id' => $request->farms_id,
            'saldo' => $updatedSaldo,
            'pendapatan' => $request->pendapatan,
            'tanggal' => $tanggal,
        ]);

        return response()->json([
            'message' => 'Pendapatan berhasil dicatat.',
            'data' => $pendapatan,
        ], 201);
    }

    public function storePengeluaran(Request $request)
    {
        $request->validate([
            'farms_id' => 'required|exists:farms,id',
            'jenis_pengeluaran' => 'required|in:biaya_pakan,biaya_bibit,gaji_pekerja,biaya_perawatan,biaya_lainnya',
            'jumlah_pengeluaran' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        $pengeluaran = Pengeluaran::create($request->all());
        return response()->json([
            'message' => 'Pengeluaran berhasil dicatat.',
            'data' => $pengeluaran,
        ], 201);
    }

    public function generateLaporanKeuangan(Request $request)
    {
        $request->validate([
            'farms_id' => 'required|exists:farms,id',
        ]);

        $totalPendapatan = Pendapatan::where('farms_id', $request->farms_id)->sum('pendapatan');
        $totalPengeluaran = Pengeluaran::where('farms_id', $request->farms_id)->sum('jumlah_pengeluaran');
        $saldo = $totalPendapatan - $totalPengeluaran;

        $laporan = LaporanKeuangan::create([
            'farms_id' => $request->farms_id,
            'id_pendapatan' => Pendapatan::where('farms_id', $request->farms_id)->latest()->value('id'),
            'id_pengeluaran' => Pengeluaran::where('farms_id', $request->farms_id)->latest()->value('id'),
            'saldo' => $saldo,
            'total_pendapatan' => $totalPendapatan,
            'total_pengeluaran' => $totalPengeluaran,
            'keuntungan_bersih' => $saldo,
        ]);

        return response()->json([
            'message' => 'Laporan keuangan berhasil dibuat.',
            'data' => $laporan,
        ], 201);
    }
}
