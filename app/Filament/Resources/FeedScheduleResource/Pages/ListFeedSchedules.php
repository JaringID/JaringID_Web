<?php

namespace App\Filament\Resources\FeedScheduleResource\Pages;

use App\Filament\Resources\FeedScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeedSchedules extends ListRecords
{
    protected static string $resource = FeedScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
