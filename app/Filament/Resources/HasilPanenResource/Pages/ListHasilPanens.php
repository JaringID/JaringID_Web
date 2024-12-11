<?php

namespace App\Filament\Resources\HasilPanenResource\Pages;

use App\Filament\Resources\HasilPanenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHasilPanens extends ListRecords
{
    protected static string $resource = HasilPanenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
