<?php

namespace App\Filament\Widgets;

use App\Models\Farm;
use Closure;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class Tambak extends BaseWidget
{
    public function getHeading(): string
    {
        return 'Daftar Tambak';
    }

    protected function getTableQuery(): Builder
    {
        // Filter data tambak berdasarkan pengguna yang sedang login
        return Farm::query()
            ->where('user_id', auth()->id())
            ->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')
                ->label('Nama'),
            Tables\Columns\TextColumn::make('description')
                ->label('Deskripsi'),
        ];
    }
}
