<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Farm;
use App\Models\Sales;
use App\Models\Harvest;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\SalesResource\Pages;

class SalesResource extends Resource
{
    protected static ?string $model = Sales::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Sales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('farm_id')
                    ->label('Farm')
                    ->options(Farm::query()->pluck('name', 'id')->toArray())
                    ->required(),
                Select::make('harvest_id')
                    ->label('Harvest')
                    ->options(Harvest::query()->pluck('id', 'id')->toArray())
                    ->required(),
                DatePicker::make('sale_date')
                    ->label('Sale Date')
                    ->required(),
                TextInput::make('quantity')
                    ->label('Quantity Sold')
                    ->required()
                    ->numeric(),
                TextInput::make('total_price')
                    ->label('Total Sale Amount')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('farm.name')->label('Farm Name'),
                TextColumn::make('harvest.quantity')->label('Harvest Quantity'),
                TextColumn::make('sale_date')->label('Sale Date')->date(),
                TextColumn::make('quantity')->label('Quantity Sold'),
                TextColumn::make('total_price')->label('Total Sale Amount'),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
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
            // Definisikan relasi jika ada
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSales::route('/create'),
            'edit' => Pages\EditSales::route('/{record}/edit'),
        ];
    }
}
