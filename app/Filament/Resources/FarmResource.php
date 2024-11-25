<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FarmResource\Pages;
use App\Filament\Resources\FarmResource\RelationManagers;
use App\Models\Farm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FarmResource extends Resource
{
    protected static ?string $model = Farm::class;
    protected static ?string $pluralLabel = 'Tambak';


    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = "Tambak";

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
            // Misalnya untuk relasi farm dengan user (owner atau manager)
            Forms\Components\Select::make('user_id')
                ->label('Manajer Tambak')
                ->relationship('user', 'name')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Nama Tambak')
                ->searchable(),
            Tables\Columns\TextColumn::make('description')
                ->label('Deskripsi Tambak')
                ->limit(50), // Membatasi panjang deskripsi yang ditampilkan
            Tables\Columns\TextColumn::make('user.name')
                ->label('Manajer Tambak')
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Di buat')
                ->dateTime(),
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
            'index' => Pages\ListFarms::route('/'),
            'create' => Pages\CreateFarm::route('/create'),
            'edit' => Pages\EditFarm::route('/{record}/edit'),
        ];
    }
}
