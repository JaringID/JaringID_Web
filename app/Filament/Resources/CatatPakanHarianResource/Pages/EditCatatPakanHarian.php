<?php

namespace App\Filament\Resources\CatatPakanHarianResource\Pages;

use App\Filament\Resources\CatatPakanHarianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatatPakanHarian extends EditRecord
{
    protected static string $resource = CatatPakanHarianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
