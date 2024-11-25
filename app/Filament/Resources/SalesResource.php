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
    protected static ?string $pluralLabel = 'Penjualan';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Penjualan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('farm_id')
                    ->label('Tambak')
                    ->options(Farm::query()->pluck('name', 'id')->toArray())
                    ->required(),
                Select::make('harvest_id')
                    ->label('Panen')
                    ->options(Harvest::query()->pluck('id', 'id')->toArray())
                    ->required(),
                DatePicker::make('sale_date')
                    ->label('tanggal Penjualan')
                    ->required(),
                TextInput::make('quantity')
                    ->label('Jumlah yang Terjual')
                    ->required()
                    ->numeric(),
                TextInput::make('price')
                    ->label('Harga')
                    ->required()
                    ->numeric(),
                TextInput::make('total_amount')
                    ->label('Total Pendapatan')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('farm.name')->label('Nama Tambak'),
                TextColumn::make('harvest.quantity')->label('Jumlah Panen'),
                TextColumn::make('sale_date')->label('Tanggal Penjualan')->date(),
                TextColumn::make('quantity')->label('Jumlah yang terjual'),
                TextColumn::make('total_amount')->label('Total Pendapatan'),
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
