<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KolamResource\Pages;
use App\Filament\Resources\KolamResource\RelationManagers;
use App\Models\Kolam;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KolamResource extends Resource
{
    protected static ?string $model = Kolam::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_kolam')
                    ->label('Nama Kolam')
                    ->required(),

                Forms\Components\Select::make('farm_id')
                    ->label('Tambak')
                    ->relationship('farm', 'name')
                    ->required(),

                Forms\Components\Radio::make('tipe_kolam')
                    ->label('Tipe Kolam')
                    ->options([
                        'kotak' => 'Kotak',
                        'bulat' => 'Bulat',
                    ])
                    ->required()
                    ->reactive(),

                Forms\Components\TextInput::make('panjang_kolam')
                    ->label('Panjang Kolam (m)')
                    ->numeric()
                    ->visible(fn ($get) => $get('tipe_kolam') === 'kotak'),

                Forms\Components\TextInput::make('lebar_kolam')
                    ->label('Lebar Kolam (m)')
                    ->numeric()
                    ->visible(fn ($get) => $get('tipe_kolam') === 'kotak'),

                Forms\Components\TextInput::make('diameter_kolam')
                    ->label('Diameter Kolam (m)')
                    ->numeric()
                    ->visible(fn ($get) => $get('tipe_kolam') === 'bulat'),

                Forms\Components\TextInput::make('kedalaman_kolam')
                    ->label('Kedalaman Kolam (m)')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            // Tambahkan kolom tabel
            Tables\Columns\TextColumn::make('nama_kolam')->label('Nama Kolam'),
            Tables\Columns\TextColumn::make('farm.name')->label('Nama Tambak'),
            Tables\Columns\TextColumn::make('tipe_kolam')->label('Tipe Kolam'),
            Tables\Columns\TextColumn::make('panjang_kolam')->label('Panjang Kolam'),
            Tables\Columns\TextColumn::make('lebar_kolam')->label('Lebar Kolam'),
            Tables\Columns\TextColumn::make('diameter_kolam')->label('Diameter Kolam'),
            Tables\Columns\TextColumn::make('kedalaman_kolam')->label('Kedalaman (m)'),
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getEloquentQuery(): Builder
{
    // Membatasi data hanya untuk kolam milik user yang sedang login
    return parent::getEloquentQuery()->whereHas('farm', function ($query) {
        $query->where('user_id', auth()->id());
    });
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKolams::route('/'),
            'create' => Pages\CreateKolam::route('/create'),
            'edit' => Pages\EditKolam::route('/{record}/edit'),
        ];
    }
}
