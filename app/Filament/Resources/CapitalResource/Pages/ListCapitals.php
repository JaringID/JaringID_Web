<?php

namespace App\Filament\Resources\CapitalResource\Pages;

use App\Filament\Resources\CapitalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCapitals extends ListRecords
{
    protected static string $resource = CapitalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
