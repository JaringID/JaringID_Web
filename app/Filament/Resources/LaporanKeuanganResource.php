<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanKeuanganResource\Pages;
use App\Filament\Resources\LaporanKeuanganResource\RelationManagers;
use App\Models\LaporanKeuangan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaporanKeuanganResource extends Resource
{
    protected static ?string $model = LaporanKeuangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Laporan Keuangan';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('farms_id')
                ->relationship('farm', 'name')
                ->options(function () {
                    return \App\Models\Farm::where('user_id', auth()->id())
                        ->pluck('name', 'id');
                })
                ->live()
                ->afterStateUpdated(function($state, Forms\Set $set) {
                    $set('id_pendapatan', null);
                    $set('id_pengeluaran', null);
                })
                ->required()
                ->label('Farm'),

            Forms\Components\Select::make('id_pendapatan')
                ->relationship('pendapatan', 'id')
                ->options(function (Forms\Get $get) {
                    $pendapatanId = $get('id_pendapatan');
                    if (!$pendapatanId) {
                        return [];
                    }
                    return \App\Models\Pendapatan::where('id_pendapatan', $pendapatanId)
                        ->pluck('pendapatan', 'id');
                })
                ->required()
                ->label('Pendapatan'),

            Forms\Components\Select::make('id_pengeluaran')
                ->relationship('pengeluaran', 'id')
                ->options(function (Forms\Get $get) {
                    $pengeluaranId = $get('id_pengeluaran');
                    if (!$pengeluaranId) {
                        return [];
                    }
                    return \App\Models\Pengeluaran::where('id_pengeluaran', $pengeluaranId)
                        ->pluck('jumlah_pengeluaran', 'id');
                })
                ->required()
                ->label('Pengeluaran'),

            Forms\Components\TextInput::make('saldo')
                ->required()
                ->numeric()
                ->prefix('Rp')
                ->label('Saldo'),

            Forms\Components\TextInput::make('total_pendapatan')
                ->required()
                ->numeric()
                ->prefix('Rp')
                ->label('Total Pendapatan'),

            Forms\Components\TextInput::make('total_pengeluaran')
                ->required()
                ->numeric()
                ->prefix('Rp')
                ->label('Total Pengeluaran'),

            Forms\Components\TextInput::make('keuntungan_bersih')
                ->required()
                ->numeric()
                ->prefix('Rp')
                ->label('Keuntungan Bersih'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('farm.name')
                ->sortable()
                ->searchable()
                ->label('Farm'),

            Tables\Columns\TextColumn::make('saldo')
                ->money('IDR')
                ->sortable()
                ->label('Saldo'),

            Tables\Columns\TextColumn::make('total_pendapatan')
                ->money('IDR')
                ->sortable()
                ->label('Total Pendapatan'),

            Tables\Columns\TextColumn::make('total_pengeluaran')
                ->money('IDR')
                ->sortable()
                ->label('Total Pengeluaran'),

            Tables\Columns\TextColumn::make('keuntungan_bersih')
                ->money('IDR')
                ->sortable()
                ->label('Keuntungan Bersih'),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('farm')
                ->relationship('farm', 'name')
                ->label('Filter by Farm'),
        ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function canView($record): bool
{
    $user = auth()->user();
    return in_array($user->role, ['owner', 'farm_manager']);
}

public static function canViewAny(): bool
{
    $user = auth()->user();
    return in_array($user->role, ['owner', 'farm_manager']);
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporanKeuangans::route('/'),
            'edit' => Pages\EditLaporanKeuangan::route('/{record}/edit'),
        ];
    }
}
