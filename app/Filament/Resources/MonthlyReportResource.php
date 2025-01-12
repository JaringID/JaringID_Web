<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MonthlyReportResource\Pages;
use App\Filament\Resources\MonthlyReportResource\RelationManagers;
use App\Models\MonthlyReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MonthlyReportResource extends Resource
{
    protected static ?string $model = MonthlyReport::class;
    protected static ?string $pluralLabel = 'Laporan Bulanan';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = "Laporan Bulanan";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('farms_id')
                    ->relationship('farm', 'name')
                    ->label('Nama Tambak')
                    ->required(),

                Forms\Components\Select::make('kolams_id')
                    ->relationship('kolam', 'nama_kolam')
                    ->label('Nama Kolam')
                    ->required(),

                Forms\Components\Select::make('siklus_id')
                    ->relationship('siklus', 'status_siklus')
                    ->label('Siklus')
                    ->required(),

                Forms\Components\Select::make('hasil_panens_id')
                    ->relationship('hasilPanen', 'jenis_panen')
                    ->required()
                    ->label('Hasil Panen'),


                Forms\Components\Select::make('catat_pakan_harian_id')
                    ->relationship('catatPakanHarian', 'tanggal')
                    ->label('Tanggal Catat Pakan Harian')
                    ->required(),

                Forms\Components\DatePicker::make('report_month')
                    ->label('Bulan Laporan')
                    ->required(),

                Forms\Components\Textarea::make('details')
                    ->label('Rincian'),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('farm.name')
                    ->label('Nama Tambak')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('kolam.nama_kolam')
                    ->label('Nama Kolam')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('siklus.status_siklus')
                    ->label('Status Siklus')
                    ->sortable(),

                Tables\Columns\TextColumn::make('hasilPanen.tanggal_panen')
                    ->label('Tanggal Panen')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('hasilPanen.jenis_panen')
                    ->label('Jenis Panen')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('hasilPanen.total_berat')
                    ->label('Total Berat')
                    ->sortable(),

                Tables\Columns\TextColumn::make('hasilPanen.pembeli')
                    ->label('Pembeli')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('catatPakanHarian.tanggal')
                    ->label('Tanggal Pakan')
                    ->date(),

                Tables\Columns\TextColumn::make('report_month')
                    ->label('Bulan Laporan')
                    ->date(),

                Tables\Columns\TextColumn::make('details')
                    ->label('Rincian')
                    ->limit(50),
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
            'index' => Pages\ListMonthlyReports::route('/'),
            'create' => Pages\CreateMonthlyReport::route('/create'),
            'edit' => Pages\EditMonthlyReport::route('/{record}/edit'),
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
