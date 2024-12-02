<?php

namespace App\Filament\Resources\KolamResource\Pages;

use App\Filament\Resources\KolamResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKolam extends EditRecord
{
    protected static string $resource = KolamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
