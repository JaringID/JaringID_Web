<?php
 
namespace App\Filament\Widgets;
 
use App\Models\Farm;
use App\Models\Order;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
 
class LatestOrders extends BaseWidget
{
    protected function getTableQuery(): Builder
    {
        return Farm::query()->latest();
    }
 
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id'),
            Tables\Columns\TextColumn::make('name')
                ->label('nama'),
            Tables\Columns\TextColumn::make('description')
                ->label('desc'),
        ];
    }
}