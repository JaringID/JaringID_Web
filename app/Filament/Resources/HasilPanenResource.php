<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HasilPanenResource\Pages;
use App\Models\HasilPanen;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class HasilPanenResource extends Resource
{
    protected static ?string $model = HasilPanen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Hasil Panen';

    protected static ?string $pluralLabel = 'Hasil Panen';

    public static function form(Forms\Form $form): Forms\Form
{
    return $form
        ->schema([
            Card::make()
                ->schema([
                    Select::make('farms_id')
                        ->label('Farm')
                        ->relationship('farm', 'name')
                        ->required(),

                    Select::make('kolams_id')
                        ->label('Kolam')
                        ->relationship('kolam', 'nama_kolam')
                        ->required(),

                    Select::make('siklus_id')
                        ->label('Siklus')
                        ->relationship('siklus', 'tanggal_tebar')
                        ->required(),

                    DatePicker::make('tanggal_panen')
                        ->label('Tanggal Panen')
                        ->required(),

                    Select::make('jenis_panen')
                        ->label('Jenis Panen')
                        ->options([
                            'Total' => 'Total',
                            'Parsial' => 'Parsial',
                            'Gagal' => 'Gagal',
                        ])
                        ->required()
                        ->reactive() // Menambahkan reaktivitas pada jenis panen
                        ->afterStateUpdated(fn ($state, callable $set) => self::updateTotalHarga($set)),

                    TextInput::make('total_berat')
                        ->label('Total Berat (Kg)')
                        ->numeric()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn ($state, callable $set) => self::updateTotalHarga($set)),

                    TextInput::make('harga_per_kg')
                        ->label('Harga per Kg (Rp)')
                        ->numeric()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn ($state, callable $set) => self::updateTotalHarga($set)),

                    TextInput::make('total_harga')
                        ->label('Total Harga (Rp)')
                        ->numeric()
                        ->disabled(),

                    TextInput::make('pembeli')
                        ->label('Pembeli')
                        ->nullable(),

                    TextInput::make('catatan')
                        ->label('Catatan')
                        ->nullable(),
                ]),
        ]);
}

// Method untuk memperbarui total harga berdasarkan jenis panen
// Method untuk memperbarui total harga berdasarkan jenis panen
protected static function updateTotalHarga(callable $set)
{
    // Ambil nilai berat, harga per kg, dan jenis panen dari form
    $berat = request()->input('total_berat');
    $harga = request()->input('harga_per_kg');
    $jenisPanen = request()->input('jenis_panen');

    // Periksa apakah keduanya ada nilainya
    if ($berat && $harga) {
        // Logika perhitungan total harga berdasarkan jenis panen
        if ($jenisPanen == 'Total' || $jenisPanen == 'Gagal') {
            // Jika jenis panen Total atau Gagal, hitung total harga biasa
            $total = $berat * $harga;
        } elseif ($jenisPanen == 'Parsial') {
            // Jika jenis panen Parsial, hitung dengan pengurangan (misal 0.75)
            $total = $berat * $harga * 0.75;  // Ganti 0.75 dengan faktor yang sesuai
        }
        // Set total harga yang sudah dihitung
        $set('total_harga', $total);
    } else {
        // Jika tidak ada nilai berat atau harga, set total harga ke 0
        $set('total_harga', 0);
    }
}




    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('farm.name')
                    ->label('Farm')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kolam.nama_kolam')
                    ->label('Kolam')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('siklus.tanggal_tebar')
                    ->label('Siklus')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('tanggal_panen')
                    ->label('Tanggal Panen')
                    ->date(),

                BadgeColumn::make('jenis_panen')
                    ->label('Jenis Panen')
                    ->colors([
                        'success' => 'Total',
                        'warning' => 'Parsial',
                        'danger' => 'Gagal',
                    ]),

                TextColumn::make('total_berat')
                    ->label('Total Berat (Kg)')
                    ->sortable(),

                TextColumn::make('harga_per_kg')
                    ->label('Harga per Kg (Rp)')
                    ->sortable(),

                TextColumn::make('total_harga')
                    ->label('Total Harga (Rp)')
                    ->sortable(),

                TextColumn::make('pembeli')
                    ->label('Pembeli')
                    ->searchable(),

                TextColumn::make('catatan')
                    ->label('Catatan')
                    ->limit(50),
            ])
            ->filters([
                Tables\Filters\Filter::make('jenis_panen')
                    ->label('Jenis Panen')
                    ->query(fn (Builder $query) => $query->whereNotNull('jenis_panen'))
                    ->form([
                        Select::make('jenis_panen')
                            ->label('Jenis Panen')
                            ->options([
                                'Total' => 'Total',
                                'Parsial' => 'Parsial',
                                'Gagal' => 'Gagal',
                            ]),
                    ]),
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
            // Tambahkan Relation Manager jika ada.
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHasilPanens::route('/'),
            'create' => Pages\CreateHasilPanen::route('/create'),
            'edit' => Pages\EditHasilPanen::route('/{record}/edit'),
        ];
    }
}
