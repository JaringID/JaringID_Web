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

        // Cek apakah ada data dengan farms_id dan tanggal yang sama
        $pendapatan = Pendapatan::where('farms_id', $request->farms_id)
            ->where('tanggal', $tanggal)
            ->first();

        if ($pendapatan) {
            // Jika data ditemukan, update saldo
            $pendapatan->saldo += $request->saldo;
            $pendapatan->save();
        } else {
            // Jika data tidak ditemukan, buat baris baru
            $lastSaldo = Pendapatan::where('farms_id', $request->farms_id)->latest('tanggal')->value('saldo') ?? 0;
            $updatedSaldo = $lastSaldo + $request->saldo;

            $pendapatan = Pendapatan::create([
                'farms_id' => $request->farms_id,
                'saldo' => $updatedSaldo,
                'tanggal' => $tanggal,
            ]);
        }

        return response()->json([
            'message' => 'Saldo berhasil dicatat.',
            'data' => $pendapatan,
        ], 200);
    }

    public function catatPendapatan(Request $request)
    {
        $request->validate([
            'farms_id' => 'required|exists:farms,id',
            'pendapatan' => 'required|numeric|min:0',
            'tanggal' => 'required|date_format:d/m/Y',
        ]);

        $tanggal = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');

        // Cek apakah ada data pendapatan dengan tanggal dan farms_id yang sama
        $pendapatan = Pendapatan::where('farms_id', $request->farms_id)
            ->where('tanggal', $tanggal)
            ->first();

        if ($pendapatan) {
            // Jika ditemukan, update pendapatan dan saldo
            $pendapatan->pendapatan += $request->pendapatan;
            $pendapatan->saldo += $request->pendapatan;
            $pendapatan->save();
        } else {
            // Jika tidak ditemukan, buat data baru
            $lastSaldo = Pendapatan::where('farms_id', $request->farms_id)->latest('tanggal')->value('saldo') ?? 0;
            $updatedSaldo = $lastSaldo + $request->pendapatan;

            $pendapatan = Pendapatan::create([
                'farms_id' => $request->farms_id,
                'pendapatan' => $request->pendapatan,
                'saldo' => $updatedSaldo,
                'tanggal' => $tanggal,
            ]);
        }

        return response()->json([
            'message' => 'Pendapatan berhasil dicatat.',
            'data' => $pendapatan,
        ], 200);
    }

    public function storePengeluaran(Request $request)
    {
        $request->validate([
            'farms_id' => 'required|exists:farms,id',
            'jenis_pengeluaran' => 'required|in:biaya_pakan,biaya_bibit,gaji_pekerja,biaya_perawatan,biaya_lainnya',
            'jumlah_pengeluaran' => 'required|numeric|min:0',
            'tanggal' => 'required|date_format:d/m/Y',
        ]);

        $tanggal = \Carbon\Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');

        $pendapatan = Pendapatan::where('farms_id', $request->farms_id)->latest('tanggal')->first();

        if (!$pendapatan) {
            return response()->json([
                'message' => 'Tidak ditemukan saldo sebelumnya untuk farm ini.',
            ], 400);
        }

        if ($pendapatan->saldo < $request->jumlah_pengeluaran) {
            return response()->json([
                'message' => 'Saldo tidak mencukupi untuk pengeluaran ini.',
            ], 400);
        }

        // Kurangi saldo pada pendapatan
        $pendapatan->saldo -= $request->jumlah_pengeluaran;
        $pendapatan->save();

        $pengeluaran = Pengeluaran::create([
            'farms_id' => $request->farms_id,
            'jenis_pengeluaran' => $request->jenis_pengeluaran,
            'jumlah_pengeluaran' => $request->jumlah_pengeluaran,
            'tanggal' => $tanggal,
        ]);

        return response()->json([
            'message' => 'Pengeluaran berhasil dicatat.',
            'data' => [
                'pengeluaran' => $pengeluaran,
                'saldo_terbaru' => $pendapatan->saldo,
            ],
        ], 201);
    }

    public function getLaporanKeuangan(Request $request)
    {
        $request->validate([
            'farms_id' => 'required|exists:farms,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:' . date('Y'),
        ]);
        $farms_id = $request->farms_id;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        // Total pendapatan dan pengeluaran per bulan
        $totalPendapatan = Pendapatan::where('farms_id', $farms_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('pendapatan');
        $totalPengeluaran = Pengeluaran::where('farms_id', $farms_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah_pengeluaran');
        // Saldo (pendapatan - pengeluaran)
        $selisih = $totalPendapatan - $totalPengeluaran;
        // Return JSON response
        return response()->json([
            'message' => 'Laporan berhasil diambil',
            'data' => [
                [
                    'farms_id' => $farms_id,
                    'year' => $tahun,
                    'month' => $bulan,
                    'total_pendapatan' => $totalPendapatan,
                    'total_pengeluaran' => $totalPengeluaran,
                    'keuntungan_bersih' => $selisih,
                ]
            ]
        ]);
    }

    public function storeLaporanKeuangan(Request $request)
    {
        $request->validate([
            'farms_id' => 'required|exists:farms,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $farms_id = $request->farms_id;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Mengambil data laporan keuangan
        $totalPendapatan = Pendapatan::where('farms_id', $farms_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('pendapatan');

        $totalPengeluaran = Pengeluaran::where('farms_id', $farms_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah_pengeluaran');

        $totalBiayaBibit = Pengeluaran::where('farms_id', $farms_id)
            ->where('jenis_pengeluaran', 'biaya_bibit')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah_pengeluaran');

        $totalBiayaPakan = Pengeluaran::where('farms_id', $farms_id)
            ->where('jenis_pengeluaran', 'biaya_pakan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah_pengeluaran');

        $totalGajiKaryawan = Pengeluaran::where('farms_id', $farms_id)
            ->where('jenis_pengeluaran', 'gaji_pekerja')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah_pengeluaran');

        $totalBiayaPerawatan = Pengeluaran::where('farms_id', $farms_id)
            ->where('jenis_pengeluaran', 'biaya_perawatan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah_pengeluaran');

        $totalBiayaLainnya = Pengeluaran::where('farms_id', $farms_id)
            ->where('jenis_pengeluaran', 'biaya_lainnya')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('jumlah_pengeluaran');

        $keuntunganBersih = $totalPendapatan - $totalPengeluaran;

        $laporanKeuangan = new LaporanKeuangan();
        $laporanKeuangan->farms_id = $farms_id;
        $laporanKeuangan->year = $tahun;
        $laporanKeuangan->month = $bulan;
        $laporanKeuangan->total_pendapatan = $totalPendapatan;
        $laporanKeuangan->total_pengeluaran = $totalPengeluaran;
        $laporanKeuangan->keuntungan_bersih = $keuntunganBersih;
        $laporanKeuangan->total_biaya_bibit = $totalBiayaBibit;
        $laporanKeuangan->total_biaya_pakan = $totalBiayaPakan;
        $laporanKeuangan->total_gaji_karyawan = $totalGajiKaryawan;
        $laporanKeuangan->total_biaya_perawatan = $totalBiayaPerawatan;
        $laporanKeuangan->total_biaya_lainnya = $totalBiayaLainnya;
        $laporanKeuangan->save();

        // Return response JSON
        return response()->json([
            'message' => 'Laporan keuangan berhasil disimpan',
            'data' => $laporanKeuangan
        ], 201);
    }
}
