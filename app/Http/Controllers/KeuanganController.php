<?php

namespace App\Http\Controllers;

use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use App\Models\LaporanKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class KeuanganController extends Controller
{
    /**
     * Mencatat saldo awal atau tambahan saldo.
     */
    public function catatSaldo(Request $request)
    {
        $validated = $request->validate([
            'farms_id' => 'required|exists:farms,id',
            'saldo'    => 'required|numeric|min:0',
            'tanggal'  => 'required|date_format:d/m/Y',
        ]);

        $tanggal = Carbon::createFromFormat('d/m/Y', $validated['tanggal'])->format('Y-m-d');

        $pendapatan = Pendapatan::firstOrNew([
            'farms_id' => $validated['farms_id'],
            'tanggal'  => $tanggal,
        ]);

        if ($pendapatan->exists) {
            $pendapatan->saldo += $validated['saldo'];
        } else {
            $lastSaldo = Pendapatan::where('farms_id', $validated['farms_id'])->latest('tanggal')->value('saldo') ?? 0;
            $pendapatan->saldo = $lastSaldo + $validated['saldo'];
        }

        $pendapatan->save();

        return response()->json([
            'message' => 'Saldo berhasil dicatat.',
            'data'    => $pendapatan,
        ], 200);
    }

    /**
     * Mencatat pendapatan baru dan update saldo.
     */
    public function catatPendapatan(Request $request)
    {
        $validated = $request->validate([
            'farms_id'   => 'required|exists:farms,id',
            'pendapatan' => 'required|numeric|min:0',
            'tanggal'    => 'required|date_format:d/m/Y',
        ]);

        $tanggal = Carbon::createFromFormat('d/m/Y', $validated['tanggal'])->format('Y-m-d');

        $pendapatan = Pendapatan::firstOrNew([
            'farms_id' => $validated['farms_id'],
            'tanggal'  => $tanggal,
        ]);

        if ($pendapatan->exists) {
            $pendapatan->pendapatan += $validated['pendapatan'];
            $pendapatan->saldo += $validated['pendapatan'];
        } else {
            $lastSaldo = Pendapatan::where('farms_id', $validated['farms_id'])->latest('tanggal')->value('saldo') ?? 0;
            $pendapatan->pendapatan = $validated['pendapatan'];
            $pendapatan->saldo = $lastSaldo + $validated['pendapatan'];
        }

        $pendapatan->save();

        return response()->json([
            'message' => 'Pendapatan berhasil dicatat.',
            'data'    => $pendapatan,
        ], 200);
    }

    /**
     * Mencatat pengeluaran dan mengurangi saldo.
     */
    public function storePengeluaran(Request $request)
    {
        $validated = $request->validate([
            'farms_id'           => 'required|exists:farms,id',
            'jenis_pengeluaran'  => 'required|in:biaya_pakan,biaya_bibit,gaji_pekerja,biaya_perawatan,biaya_lainnya',
            'jumlah_pengeluaran' => 'required|numeric|min:0',
            'tanggal'            => 'required|date_format:d/m/Y',
        ]);

        $tanggal = Carbon::createFromFormat('d/m/Y', $validated['tanggal'])->format('Y-m-d');

        $pendapatan = Pendapatan::where('farms_id', $validated['farms_id'])->latest('tanggal')->first();

        if (!$pendapatan) {
            return response()->json(['message' => 'Tidak ditemukan saldo sebelumnya.'], 400);
        }

        if ($pendapatan->saldo < $validated['jumlah_pengeluaran']) {
            return response()->json(['message' => 'Saldo tidak mencukupi.'], 400);
        }

        $pendapatan->decrement('saldo', $validated['jumlah_pengeluaran']);

        $pengeluaran = Pengeluaran::create([
            'farms_id'           => $validated['farms_id'],
            'jenis_pengeluaran'  => $validated['jenis_pengeluaran'],
            'jumlah_pengeluaran' => $validated['jumlah_pengeluaran'],
            'tanggal'            => $tanggal,
        ]);

        return response()->json([
            'message' => 'Pengeluaran berhasil dicatat.',
            'data' => [
                'pengeluaran'    => $pengeluaran,
                'saldo_terbaru'  => $pendapatan->saldo,
            ],
        ], 201);
    }

    /**
     * Menampilkan laporan keuangan bulanan.
     */
    public function getLaporanKeuangan(Request $request)
    {
        $validated = $request->validate([
            'farms_id' => 'required|exists:farms,id',
            'bulan'    => 'required|integer|min:1|max:12',
            'tahun'    => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $farms_id = $validated['farms_id'];
        $bulan    = $validated['bulan'];
        $tahun    = $validated['tahun'];

        $pengeluaran = Pengeluaran::where('farms_id', $farms_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        $rincian = [
            'total_biaya_pakan'     => $pengeluaran->clone()->where('jenis_pengeluaran', 'biaya_pakan')->sum('jumlah_pengeluaran'),
            'total_biaya_bibit'     => $pengeluaran->clone()->where('jenis_pengeluaran', 'biaya_bibit')->sum('jumlah_pengeluaran'),
            'total_gaji_pekerja'    => $pengeluaran->clone()->where('jenis_pengeluaran', 'gaji_pekerja')->sum('jumlah_pengeluaran'),
            'total_biaya_perawatan' => $pengeluaran->clone()->where('jenis_pengeluaran', 'biaya_perawatan')->sum('jumlah_pengeluaran'),
            'total_biaya_lainnya'   => $pengeluaran->clone()->where('jenis_pengeluaran', 'biaya_lainnya')->sum('jumlah_pengeluaran'),
        ];

        $totalPengeluaran = array_sum($rincian);

        $totalPendapatan = Pendapatan::where('farms_id', $farms_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->sum('pendapatan');

        $keuntunganBersih = $totalPendapatan - $totalPengeluaran;

        return response()->json([
            'message' => 'Laporan berhasil diambil',
            'data'    => [
                'farms_id'           => $farms_id,
                'year'               => $tahun,
                'month'              => $bulan,
                'total_pendapatan'   => $totalPendapatan,
                'total_pengeluaran'  => $totalPengeluaran,
                'keuntungan_bersih'  => $keuntunganBersih,
                'rincian_pengeluaran'=> $rincian,
            ]
        ]);
    }

    /**
     * Menyimpan laporan keuangan bulanan ke database.
     */
    public function storeLaporanKeuangan(Request $request)
    {
        $validated = $request->validate([
            'farms_id' => 'required|exists:farms,id',
            'bulan'    => 'required|integer|min:1|max:12',
            'tahun'    => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $farms_id = $validated['farms_id'];
        $bulan    = $validated['bulan'];
        $tahun    = $validated['tahun'];

        $laporan = new LaporanKeuangan([
            'farms_id'             => $farms_id,
            'year'                 => $tahun,
            'month'                => $bulan,
            'total_pendapatan'     => Pendapatan::where('farms_id', $farms_id)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('pendapatan'),
            'total_pengeluaran'    => Pengeluaran::where('farms_id', $farms_id)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('jumlah_pengeluaran'),
            'total_biaya_bibit'    => Pengeluaran::where('farms_id', $farms_id)->where('jenis_pengeluaran', 'biaya_bibit')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('jumlah_pengeluaran'),
            'total_biaya_pakan'    => Pengeluaran::where('farms_id', $farms_id)->where('jenis_pengeluaran', 'biaya_pakan')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('jumlah_pengeluaran'),
            'total_gaji_karyawan'  => Pengeluaran::where('farms_id', $farms_id)->where('jenis_pengeluaran', 'gaji_pekerja')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('jumlah_pengeluaran'),
            'total_biaya_perawatan'=> Pengeluaran::where('farms_id', $farms_id)->where('jenis_pengeluaran', 'biaya_perawatan')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('jumlah_pengeluaran'),
            'total_biaya_lainnya'  => Pengeluaran::where('farms_id', $farms_id)->where('jenis_pengeluaran', 'biaya_lainnya')->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->sum('jumlah_pengeluaran'),
        ]);

        $laporan->keuntungan_bersih = $laporan->total_pendapatan - $laporan->total_pengeluaran;
        $laporan->save();

        return response()->json([
            'message' => 'Laporan keuangan berhasil disimpan',
            'data'    => $laporan,
        ], 201);
    }
}
