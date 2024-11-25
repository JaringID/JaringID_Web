<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Farm;
use Filament\Tables;
use App\Models\Harvest;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HarvestResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HarvestResource\RelationManagers;

class HarvestResource extends Resource
{
    protected static ?string $model = Harvest::class;
    protected static ?string $pluralLabel = 'Pengaturan Panen';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Panen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('farm_id')
                    ->label('Tambak')
                    ->options(Farm::all()->pluck('name', 'id'))
                    ->required(),
                DatePicker::make('harvest_date')
                    ->label('Tanggal Panen')
                    ->required(),
                TextInput::make('quantity')
                    ->label('Jumlah Panen')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('farm.name')->label('Nama Tambak'),
                TextColumn::make('harvest_date')->label('Tanggal Panen'),
                TextColumn::make('quantity')->label('Jumlah Panen'),
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
            'index' => Pages\ListHarvests::route('/'),
            'create' => Pages\CreateHarvest::route('/create'),
            'edit' => Pages\EditHarvest::route('/{record}/edit'),
        ];
    }
}
