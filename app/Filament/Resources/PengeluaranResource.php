<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengeluaranResource\Pages;
use App\Filament\Resources\PengeluaranResource\RelationManagers;
use App\Models\Pengeluaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PengeluaranResource extends Resource
{
    protected static ?string $model = Pengeluaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Pengeluaran';
    protected static ?string $pluralModelLabel = 'Pengeluaran';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('farms_id')
                ->label('Tambak')
                ->relationship('farm', 'name') // Pastikan kolom 'nama' ada di tabel farms
                ->options(function () {
                    return \App\Models\Farm::where('user_id', auth()->id())
                        ->pluck('name', 'id');
                })
                ->required(),

                Forms\Components\Select::make('jenis_pengeluaran')
                ->label('Jenis Pengeluaran')
                ->options([
                    'biaya_pakan' => 'Biaya Pakan',
                    'biaya_bibit' => 'Biaya Bibit',
                    'gaji_pekerja' => 'Gaji Pekerja',
                    'biaya_perawatan' => 'Biaya Perawatan',
                    'biaya_lainnya' => 'Biaya Lainnya',
                ])
                ->required(),

            Forms\Components\TextInput::make('jumlah_pengeluaran')
                ->label('Jumlah Pengeluaran')
                ->numeric()
                ->required(),

            Forms\Components\DatePicker::make('tanggal')
                ->label('Tanggal')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('farm.name') // Pastikan kolom 'nama' ada di tabel farms
                ->label('Tambak')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('jenis_pengeluaran')
                ->label('Jenis Pengeluaran')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('jumlah_pengeluaran')
                ->label('Jumlah Pengeluaran')
                ->money('IDR') // Format angka sebagai mata uang
                ->sortable(),

            Tables\Columns\TextColumn::make('tanggal')
                ->label('Tanggal')
                ->date()
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\Filter::make('tanggal')
                ->label('Filter Tanggal')
                ->form([
                    Forms\Components\DatePicker::make('from')->label('Dari'),
                    Forms\Components\DatePicker::make('to')->label('Sampai'),
                ])
                ->query(function (Builder $query, array $data) {
                    return $query
                        ->when($data['from'], fn ($query, $date) => $query->whereDate('tanggal', '>=', $date))
                        ->when($data['to'], fn ($query, $date) => $query->whereDate('tanggal', '<=', $date));
                }),
        ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPengeluarans::route('/'),
            'create' => Pages\CreatePengeluaran::route('/create'),
            'edit' => Pages\EditPengeluaran::route('/{record}/edit'),
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
