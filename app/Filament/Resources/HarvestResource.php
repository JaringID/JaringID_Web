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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Harvest';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('farm_id')
                    ->label('Farm')
                    ->options(Farm::all()->pluck('name', 'id'))
                    ->required(),
                DatePicker::make('harvest_date')
                    ->label('Harvest Date')
                    ->required(),
                TextInput::make('quantity')
                    ->label('Quantity')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('farm.name')->label('Farm Name'),
                TextColumn::make('harvest_date')->label('Harvest Date'),
                TextColumn::make('quantity')->label('Quantity'),
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
