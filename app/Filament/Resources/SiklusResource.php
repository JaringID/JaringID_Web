<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiklusResource\Pages;
use App\Models\Siklus;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiklusResource extends Resource
{
    protected static ?string $model = Siklus::class;
    protected static ?string $navigationLabel = 'Siklus';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('farm_id')
                        ->label('Farm')
                        ->relationship('farm', 'name') // Sesuaikan dengan relasi di model Farm
                        ->required(),

                    Select::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name') // Sesuaikan dengan relasi di model User
                        ->required(),

                    Select::make('kolam_id')
                        ->label('Kolam')
                        ->relationship('kolam', 'nama_kolam') // Sesuaikan dengan relasi di model Kolam
                        ->required(),

                    TextInput::make('total_lebar')
                        ->label('Total Lebar')
                        ->numeric()
                        ->required(),

                    Select::make('tipe_lebar')
                        ->label('Tipe Lebar')
                        ->options([
                            'netto' => 'Netto',
                            'bruto' => 'Bruto',
                            'aktual' => 'Aktual',
                        ])
                        ->required(),

                    DatePicker::make('tanggal_tebar')
                        ->label('Tanggal Tebar')
                        ->required(),

                    TextInput::make('total_pakan')
                        ->label('Total Pakan')
                        ->numeric()
                        ->required(),

                    TextInput::make('biaya_pakan')
                        ->label('Biaya Pakan')
                        ->numeric()
                        ->required(),

                    TextInput::make('total_bibit')
                        ->label('Total Bibit')
                        ->numeric()
                        ->required(),

                    TextInput::make('biaya_bibit')
                        ->label('Biaya Bibit')
                        ->numeric()
                        ->required(),

                    TextInput::make('biaya_perawatan')
                        ->label('Biaya Perawatan')
                        ->numeric()
                        ->nullable(),
                ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('farm.name')
                    ->label('Farm')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kolam.nama_kolam')
                    ->label('Kolam')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('total_lebar')
                    ->label('Total Lebar')
                    ->sortable(),

                TextColumn::make('tipe_lebar')
                    ->label('Tipe Lebar')
                    ->sortable(),

                TextColumn::make('tanggal_tebar')
                    ->label('Tanggal Tebar')
                    ->date()
                    ->sortable(),

                TextColumn::make('total_pakan')
                    ->label('Total Pakan')
                    ->sortable(),

                TextColumn::make('biaya_pakan')
                    ->label('Biaya Pakan')
                    ->money('IDR', true) // Menampilkan dalam format uang
                    ->sortable(),

                TextColumn::make('total_bibit')
                    ->label('Total Bibit')
                    ->sortable(),

                TextColumn::make('biaya_bibit')
                    ->label('Biaya Bibit')
                    ->money('IDR', true)
                    ->sortable(),
                    
                    TextColumn::make('biaya_perawatan')
                    ->label('Biaya Perawatan')
                    ->money('IDR', true)
                    ->default('N/A') // Menampilkan "N/A" jika nilai null
                    ->sortable(),
                
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
            // Tambahkan relasi jika ada
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSikluses::route('/'),
            'create' => Pages\CreateSiklus::route('/create'),
            'edit' => Pages\EditSiklus::route('/{record}/edit'),
        ];
    }
}
