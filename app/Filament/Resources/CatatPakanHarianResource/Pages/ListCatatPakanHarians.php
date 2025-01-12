<?php

namespace App\Filament\Resources\CatatPakanHarianResource\Pages;

use App\Filament\Resources\CatatPakanHarianResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatatPakanHarians extends ListRecords
{
    protected static string $resource = CatatPakanHarianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
