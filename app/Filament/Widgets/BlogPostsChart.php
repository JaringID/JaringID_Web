<?php

namespace App\Filament\Widgets;

use App\Models\HasilPanen; // Model untuk hasil panen
use App\Models\Pendapatan; // Model untuk pendapatan
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Hasil Panen & Pendapatan';

    protected function getData(): array
    {
        // Mendapatkan ID pengguna yang sedang login
        $userId = Auth::id();
        $userRole = Auth::user()->role; // Mengambil peran pengguna

        // Mengambil data hasil panen berdasarkan user_id
        $panenData = HasilPanen::whereHas('farm', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->selectRaw('DATE(tanggal_panen) as tanggal, SUM(total_berat) as total_berat')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // Memformat data untuk grafik hasil panen
        $panenLabels = $panenData->pluck('tanggal')->toArray();
        $panenWeights = $panenData->pluck('total_berat')->toArray();

        // Jika pengguna adalah farm manager atau owner, tambahkan data pendapatan
        if (in_array($userRole, ['farm_manager', 'owner'])) {
            // Mengambil data pendapatan berdasarkan user_id
            $pendapatanData = Pendapatan::whereHas('farm', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->select('tanggal', 'pendapatan')
                ->orderBy('tanggal', 'asc')
                ->get();

            $pendapatanLabels = $pendapatanData->pluck('tanggal')->toArray();
            $pendapatanValues = $pendapatanData->pluck('pendapatan')->toArray();

            // Gabungkan tanggal untuk membuat label tunggal
            $allLabels = array_unique(array_merge($panenLabels, $pendapatanLabels));
            sort($allLabels);

            // Mengisi data panen dan pendapatan berdasarkan tanggal
            $panenMapped = collect($allLabels)->map(function ($tanggal) use ($panenData) {
                return $panenData->firstWhere('tanggal', $tanggal)->total_berat ?? 0;
            })->toArray();

            $pendapatanMapped = collect($allLabels)->map(function ($tanggal) use ($pendapatanData) {
                return $pendapatanData->where('tanggal', $tanggal)->sum('pendapatan') ?? 0;
            })->toArray();

            return [
                'labels' => $allLabels,
                'datasets' => [
                    [
                        'label' => 'Total Berat (kg)',
                        'data' => $panenMapped,
                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                        'borderColor' => 'rgba(75, 192, 192, 1)',
                        'borderWidth' => 2,
                    ],
                    [
                        'label' => 'Pendapatan (Rp)',
                        'data' => $pendapatanMapped,
                        'backgroundColor' => 'rgba(255, 159, 64, 0.2)',
                        'borderColor' => 'rgba(255, 159, 64, 1)',
                        'borderWidth' => 2,
                    ],
                ],
            ];
        }

        // Untuk employee, hanya kembalikan data panen
        return [
            'labels' => $panenLabels,
            'datasets' => [
                [
                    'label' => 'Total Berat (kg)',
                    'data' => $panenWeights,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 2,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Bisa diganti dengan jenis grafik lainnya, misalnya 'bar'
    }
}
