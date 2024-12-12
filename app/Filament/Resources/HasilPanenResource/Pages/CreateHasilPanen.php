<?php

namespace App\Filament\Resources\HasilPanenResource\Pages;

use App\Filament\Resources\HasilPanenResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHasilPanen extends CreateRecord
{
    protected static string $resource = HasilPanenResource::class;

    protected function afterSave(): void
    {
        parent::afterSave();

        $hasilPanen = $this->record;

        // Periksa jenis panen
        if ($hasilPanen->jenis_panen == 'parsial') {
            // Status Siklus tetap sedang_berjalan
            $hasilPanen->siklus->update(['status_siklus' => 'sedang_berjalan']);
        } elseif (in_array($hasilPanen->jenis_panen, ['total', 'gagal'])) {
            // Status Siklus berhenti, Kolam tidak aktif
            $hasilPanen->siklus->update(['status_siklus' => 'berhenti']);
            $hasilPanen->siklus->kolam->update(['status' => 'tidak_aktif']);
        }
    }
}
