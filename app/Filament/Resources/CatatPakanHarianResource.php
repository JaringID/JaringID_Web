<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatatPakanHarianResource\Pages;
use App\Models\CatatPakanHarian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Resource untuk mencatat data pakan harian.
 */
class CatatPakanHarianResource extends Resource
{
    protected static ?string $model = CatatPakanHarian::class;
    protected static ?string $navigationLabel = 'Catat Pakan Harian';
    protected static ?string $pluralLabel = 'Catat Pakan Harian';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Form input untuk mencatat pakan harian.
     */
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('farms_id')
                ->label('Farm')
                ->relationship('farm', 'name')
                ->required()
                ->options(fn () => \App\Models\Farm::where('user_id', auth()->id())->pluck('name', 'id'))
                ->live()
                ->afterStateUpdated(function ($state, Forms\Set $set) {
                    $set('kolams_id', null);
                    $set('siklus_id', null);
                    $set('hasil_panens_id', null);
                }),

            Forms\Components\Select::make('kolam_id')
                ->label('Kolam')
                ->relationship('kolam', 'nama_kolam')
                ->required()
                ->options(function (Forms\Get $get) {
                    $farmId = $get('farms_id');
                    if (!$farmId) return [];
                    return \App\Models\Kolam::where('farm_id', $farmId)->pluck('nama_kolam', 'id');
                })
                ->live()
                ->afterStateUpdated(function ($state, Forms\Set $set) {
                    $set('siklus_id', null);
                    $set('hasil_panens_id', null);
                }),

            Forms\Components\DatePicker::make('tanggal')
                ->required()
                ->label('Tanggal'),

            Forms\Components\TimePicker::make('jadwal_pertama')->label('Jadwal Pertama'),
            Forms\Components\TextInput::make('jumlah_pakan_pertama')->numeric()->label('Jumlah Pakan Pertama'),

            Forms\Components\TimePicker::make('jadwal_kedua')->label('Jadwal Kedua'),
            Forms\Components\TextInput::make('jumlah_pakan_kedua')->numeric()->label('Jumlah Pakan Kedua'),

            Forms\Components\TimePicker::make('jadwal_ketiga')->label('Jadwal Ketiga'),
            Forms\Components\TextInput::make('jumlah_pakan_ketiga')->numeric()->label('Jumlah Pakan Ketiga'),

            Forms\Components\TimePicker::make('jadwal_keempat')->label('Jadwal Keempat'),
            Forms\Components\TextInput::make('jumlah_pakan_keempat')->numeric()->label('Jumlah Pakan Keempat'),

            Forms\Components\TimePicker::make('jadwal_kelima')->label('Jadwal Kelima'),
            Forms\Components\TextInput::make('jumlah_pakan_kelima')->numeric()->label('Jumlah Pakan Kelima'),
        ]);
    }

    /**
     * Tabel daftar catatan pakan harian.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('farm.name')->label('Farm'),
                Tables\Columns\TextColumn::make('kolam.nama_kolam')->label('Kolam'),
                Tables\Columns\TextColumn::make('tanggal')->date()->label('Tanggal'),
                Tables\Columns\TextColumn::make('jadwal_pertama')->label('Jadwal Pertama'),
                Tables\Columns\TextColumn::make('jumlah_pakan_pertama')->label('Jumlah Pakan Pertama'),
                Tables\Columns\TextColumn::make('jadwal_kedua')->label('Jadwal Kedua'),
                Tables\Columns\TextColumn::make('jumlah_pakan_kedua')->label('Jumlah Pakan Kedua'),
            ])
            ->filters([
                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Dari'),
                        Forms\Components\DatePicker::make('to')->label('Sampai'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q, $date) => $q->whereDate('tanggal', '>=', $date))
                            ->when($data['to'], fn ($q, $date) => $q->whereDate('tanggal', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Relasi tambahan yang tersedia di halaman resource ini.
     */
    public static function getRelations(): array
    {
        return [
            // Bisa ditambahkan RelationManager jika diperlukan
        ];
    }

    /**
     * Halaman yang tersedia untuk resource ini.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCatatPakanHarians::route('/'),
            'create' => Pages\CreateCatatPakanHarian::route('/create'),
            'edit' => Pages\EditCatatPakanHarian::route('/{record}/edit'),
        ];
    }

    /**
     * Query yang digunakan untuk menampilkan data,
     * dibatasi hanya untuk data milik user yang login.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('farm', function ($query) {
            $query->where('user_id', auth()->id());
        });
    }
}
