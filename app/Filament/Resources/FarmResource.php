<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FarmResource\Pages;
use App\Models\Farm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FarmResource extends Resource
{
    protected static ?string $model = Farm::class;

    protected static ?string $pluralLabel = 'Tambak';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Daftar Tambak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Tambak')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextArea::make('description')
                    ->label('Deskripsi Tambak')
                    ->nullable()
                    ->maxLength(1000),
                Forms\Components\Select::make('user_id')
                    ->label('Manajer Tambak')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable(), // Memudahkan pencarian nama user
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Tambak')
                    ->searchable()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('kolam_count')
                    ->label('Jumlah Kolam')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return $record->kolams->count();
                    }),
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi Tambak')
                    ->limit(50), // Membatasi panjang teks deskripsi
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Manajer Tambak')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Tambahkan relation manager jika diperlukan
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // Membatasi data hanya untuk tambak milik user yang sedang login
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFarms::route('/'),
            'create' => Pages\CreateFarm::route('/create'),
            'edit' => Pages\EditFarm::route('/{record}/edit'),
        ];
    }
}
