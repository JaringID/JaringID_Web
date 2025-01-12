<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CapitalResource\Pages;
use App\Filament\Resources\CapitalResource\RelationManagers;
use App\Models\Capital;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CapitalResource extends Resource
{
    protected static ?string $model = Capital::class;
    protected static ?string $pluralLabel = 'Modal';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen Tambak';
    protected static ?string $navigationLabel = "Modal";


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('farm_id')
                ->label('Tambak')
                    ->relationship('farm', 'name')
                    ->required(),
                Forms\Components\TextInput::make('feed_cost')
                ->label('Biaya Pakan')
                ->numeric()->required(),
                Forms\Components\TextInput::make('seed_cost')
                ->label('Biaya Bibit')
                ->numeric()->required(),
                Forms\Components\TextInput::make('pond_cost')
                ->label('Biaya Kolam')
                ->numeric()->required(),
                Forms\Components\TextInput::make('salary_cost')
                ->label('Biaya Gaji')
                ->numeric()->required(),
                Forms\Components\TextInput::make('operational_cost')
                ->label('Biaya Operasional')
                ->numeric()->required(),
                Forms\Components\Textarea::make('description')
                ->label('Deskripsi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('farm.name')->label('Nama Tambak'),
                Tables\Columns\TextColumn::make('feed_cost')->money('IDR')->label('Biaya Pakan'),
                Tables\Columns\TextColumn::make('seed_cost')->money('IDR')->label('Biaya Bibit'),
                Tables\Columns\TextColumn::make('salary_cost')->money('IDR')->label('Biaya Gaji'),
                Tables\Columns\TextColumn::make('operational_cost')->money('IDR')->label('Biaya Operasional'),
                Tables\Columns\TextColumn::make('created_at')->date(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCapitals::route('/'),
            'create' => Pages\CreateCapital::route('/create'),
            'edit' => Pages\EditCapital::route('/{record}/edit'),
        ];
    }
    public static function shouldRegisterNavigation(): bool
{
    // Return false untuk menghapus resource dari sidebar
    return false;
}
}
