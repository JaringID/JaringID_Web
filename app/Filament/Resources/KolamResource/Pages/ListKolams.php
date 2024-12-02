<?php

namespace App\Filament\Resources\KolamResource\Pages;

use App\Filament\Resources\KolamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKolams extends ListRecords
{
    protected static string $resource = KolamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
