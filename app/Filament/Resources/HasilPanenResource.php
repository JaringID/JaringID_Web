<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Siklus;
use App\Models\HasilPanen;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HasilPanenResource\Pages;

/**
 * Resource Filament untuk mencatat dan mengelola data hasil panen.
 */
class HasilPanenResource extends Resource
{
    protected static ?string $model = HasilPanen::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Hasil Panen';
    protected static ?string $pluralLabel = 'Hasil Panen';

    /**
     * Form input untuk hasil panen.
     */
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Card::make()->schema([
                // Select Farm
                Select::make('farms_id')
                    ->label('Farm')
                    ->relationship('farm', 'name')
                    ->required()
                    ->options(fn () => \App\Models\Farm::where('user_id', auth()->id())->pluck('name', 'id'))
                    ->live()
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set(['kolams_id' => null, 'siklus_id' => null, 'hasil_panens_id' => null])),

                // Select Kolam
                Select::make('kolams_id')
                    ->label('Kolam')
                    ->relationship('kolam', 'nama_kolam')
                    ->required()
                    ->options(fn (Forms\Get $get) => $get('farms_id') ? \App\Models\Kolam::where('farm_id', $get('farms_id'))->pluck('nama_kolam', 'id') : [])
                    ->live()
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set(['siklus_id' => null, 'hasil_panens_id' => null])),

                // Select Siklus
                Select::make('siklus_id')
                    ->label('Siklus')
                    ->relationship('siklus', 'tanggal_tebar')
                    ->required()
                    ->options(fn (Forms\Get $get) => $get('kolams_id') ? \App\Models\Siklus::where('kolam_id', $get('kolams_id'))->pluck('status_siklus', 'id') : []),

                // Tanggal Panen
                DatePicker::make('tanggal_panen')
                    ->label('Tanggal Panen')
                    ->required(),

                // Jenis Panen
                Select::make('jenis_panen')
                    ->label('Jenis Panen')
                    ->options([
                        'parsial' => 'Parsial',
                        'total' => 'Total',
                        'gagal' => 'Gagal',
                    ])
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get) {
                        $siklus = Siklus::find($get('siklus_id'));
                        if ($siklus) {
                            $kolam = $siklus->kolam;
                            if (in_array($state, ['total', 'gagal'])) {
                                $siklus->update(['status_siklus' => 'berhenti']);
                                $kolam->update(['status' => 'tidak_aktif']);
                            } elseif ($state === 'parsial') {
                                $siklus->update(['status_siklus' => 'sedang_berjalan']);
                                $kolam->update(['status' => 'aktif']);
                            }
                        }
                    }),

                // Input Berat dan Harga
                TextInput::make('total_berat')
                    ->label('Total Berat (Kg)')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, $set, $get) => self::updateTotalHarga($set, $state, $get('harga_per_kg'), $get('jenis_panen'))),

                TextInput::make('harga_per_kg')
                    ->label('Harga per Kg (Rp)')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, $set, $get) => self::updateTotalHarga($set, $get('total_berat'), $state, $get('jenis_panen'))),

                TextInput::make('total_harga')
                    ->label('Total Harga (Rp)')
                    ->numeric()
                    ->disabled()
                    ->reactive(),

                // Optional Fields
                TextInput::make('pembeli')->label('Pembeli')->nullable(),
                TextInput::make('catatan')->label('Catatan')->nullable(),
            ]),
        ]);
    }

    /**
     * Menghitung dan mengisi total harga berdasarkan berat dan harga.
     */
    protected static function updateTotalHarga(callable $set, ?float $berat, ?float $harga, ?string $jenisPanen)
    {
        if ($berat && $harga) {
            $total = $berat * $harga;
            if ($jenisPanen === 'parsial') {
                $total *= 0.75;
            }
            $set('total_harga', $total);
        } else {
            $set('total_harga', 0);
        }
    }
    /**
     * Tabel data hasil panen.
     */
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('farm.name')->label('Farm')->sortable()->searchable(),
                TextColumn::make('kolam.nama_kolam')->label('Kolam')->sortable()->searchable(),
                TextColumn::make('siklus.tanggal_tebar')->label('Siklus')->sortable()->searchable(),
                TextColumn::make('tanggal_panen')->label('Tanggal Panen')->date(),
                BadgeColumn::make('jenis_panen')->label('Jenis Panen')->colors([
                    'success' => 'Total',
                    'warning' => 'Parsial',
                    'danger' => 'Gagal',
                ]),
                TextColumn::make('total_berat')->label('Total Berat (Kg)')->sortable(),
                TextColumn::make('harga_per_kg')->label('Harga per Kg (Rp)')->sortable(),
                TextColumn::make('total_harga')->label('Total Harga (Rp)')->sortable(),
                TextColumn::make('pembeli')->label('Pembeli')->searchable(),
                TextColumn::make('catatan')->label('Catatan')->limit(50),
            ])
            ->filters([
                Tables\Filters\Filter::make('jenis_panen')
                    ->label('Jenis Panen')
                    ->query(fn (Builder $query) => $query->whereNotNull('jenis_panen'))
                    ->form([
                        Select::make('jenis_panen')->label('Jenis Panen')->options([
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHasilPanens::route('/'),
            'create' => Pages\CreateHasilPanen::route('/create'),
            'edit' => Pages\EditHasilPanen::route('/{record}/edit'),
        ];
    }

    /**
     * Hanya owner dan farm_manager yang bisa membuat data.
     */
    public static function canCreate(): bool
    {
        return in_array(auth()->user()->role, ['owner', 'farm_manager']);
    }

    /**
     * Hanya owner dan farm_manager yang bisa mengedit data.
     */
    public static function canEdit($record): bool
    {
        return in_array(auth()->user()->role, ['owner', 'farm_manager']);
    }

    /**
     * Batasi data hanya yang milik user yang sedang login.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('farm', fn ($query) =>
            $query->where('user_id', auth()->id()));
    }
}
