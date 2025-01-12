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
                        ->options(function () {
                            return \App\Models\Farm::where('user_id', auth()->id())
                                ->pluck('name', 'id');
                        })
                        ->live()
                        ->afterStateUpdated(function($state, Forms\Set $set) {
                            $set('kolams_id', null);
                            $set('siklus_id', null);
                            $set('hasil_panens_id', null);
                        })
                        ->required(),

                    Select::make('kolams_id')
                        ->label('Kolam')
                        ->relationship('kolam', 'nama_kolam')
                        ->options(function (Forms\Get $get) {
                            $farmId = $get('farms_id');
                            if (!$farmId) {
                                return [];
                            }
                            return \App\Models\Kolam::where('farm_id', $farmId)
                                ->pluck('nama_kolam', 'id');
                        })
                        ->live()
                        ->afterStateUpdated(function($state, Forms\Set $set) {
                            $set('siklus_id', null);
                            $set('hasil_panens_id', null);
                        })
                        ->required(),

                    Select::make('siklus_id')
                        ->label('Siklus')
                        ->relationship('siklus', 'tanggal_tebar')
                        ->options(function (Forms\Get $get) {
                            $kolamId = $get('kolams_id');
                            if (!$kolamId) {
                                return [];
                            }
                            return \App\Models\Siklus::where('kolam_id', $kolamId)
                                ->pluck('status_siklus', 'id');
                        })
                        ->required(),

                    DatePicker::make('tanggal_panen')
                        ->label('Tanggal Panen')
                        ->required(),

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

                        TextInput::make('total_berat')
                        ->label('Total Berat (Kg)')
                        ->numeric()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            self::updateTotalHarga($set, $state, $get('harga_per_kg'), $get('jenis_panen'));
                        }),
                    

                        TextInput::make('harga_per_kg')
                        ->label('Harga per Kg (Rp)')
                        ->numeric()
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            self::updateTotalHarga($set, $get('total_berat'), $state, $get('jenis_panen'));
                        }),
                    

                    TextInput::make('total_harga')
                        ->label('Total Harga (Rp)')
                        ->numeric()
                        ->disabled()
                        ->reactive(),

                    TextInput::make('pembeli')
                        ->label('Pembeli')
                        ->nullable(),

                    TextInput::make('catatan')
                        ->label('Catatan')
                        ->nullable(),
                ]),
        ]);
}

protected static function updateTotalHarga(callable $set, ?float $berat, ?float $harga, ?string $jenisPanen)
{
    if ($berat && $harga) {
        $total = $berat * $harga;

        // Logika khusus untuk jenis panen "parsial"
        if ($jenisPanen === 'parsial') {
            $total *= 0.75; // Sesuaikan faktor pengurangan jika perlu
        }

        $set('total_harga', $total);
    } else {
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
    public static function getEloquentQuery(): Builder
{
    // Membatasi data hanya untuk kolam milik user yang sedang login
    return parent::getEloquentQuery()->whereHas('farm', function ($query) {
        $query->where('user_id', auth()->id());
    });
}
}
