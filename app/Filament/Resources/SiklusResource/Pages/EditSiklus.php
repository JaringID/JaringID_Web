<?php

namespace App\Filament\Resources\SiklusResource\Pages;

use App\Filament\Resources\SiklusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSiklus extends EditRecord
{
    protected static string $resource = SiklusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
