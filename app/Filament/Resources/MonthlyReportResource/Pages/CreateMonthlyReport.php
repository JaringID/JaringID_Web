<?php

namespace App\Filament\Resources\MonthlyReportResource\Pages;

use App\Filament\Resources\MonthlyReportResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMonthlyReport extends CreateRecord
{
    protected static ?string $navigationLabel = "Tambah Laporan Bulanan";
    protected static string $resource = MonthlyReportResource::class;
}
