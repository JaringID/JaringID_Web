<?php

namespace App\Filament\Widgets;

use App\Models\Siklus;
use App\Models\HasilPanen;
use App\Models\Pendapatan;
use App\Models\Pengeluaran;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $userId = auth()->id(); // ID pengguna yang sedang login

        // Hitung jumlah siklus yang dimiliki pengguna
        $totalCycles = Siklus::whereHas('farm', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        // Hitung total hasil panen dari tambak milik pengguna
        $totalHarvest = HasilPanen::whereHas('farm', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->sum('total_berat');

        // Hitung total pendapatan dari tambak milik pengguna
        $totalIncome = Pendapatan::whereHas('farm', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->sum('pendapatan');

        // Hitung total pengeluaran dari tambak milik pengguna
        $totalExpense = Pengeluaran::whereHas('farm', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->sum('jumlah_pengeluaran');

        // Hitung keseimbangan keuangan
        $financialBalance = $totalIncome - $totalExpense;

        return [
            Card::make('Jumlah Siklus', $totalCycles)
                ->description('Total siklus yang tercatat.')
                ->color('primary'),

            Card::make('Total Hasil Panen', number_format($totalHarvest, 2) . ' kg')
                ->description('Total hasil panen dari semua siklus.')
                ->color('success'),

            Card::make('Total Pendapatan', 'Rp ' . number_format($totalIncome, 2))
                ->description('Pendapatan dari semua sumber.')
                ->color('success'),

            Card::make('Total Pengeluaran', 'Rp ' . number_format($totalExpense, 2))
                ->description('Pengeluaran untuk operasional.')
                ->color('danger'),

            Card::make('Keseimbangan Keuangan', 'Rp ' . number_format($financialBalance, 2))
                ->description($financialBalance > 0 ? 'Keuntungan' : 'Kerugian')
                ->color($financialBalance > 0 ? 'success' : 'danger'),
        ];
    }
}
