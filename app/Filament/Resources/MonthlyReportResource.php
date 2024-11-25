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
    protected static ?string $navigationGroup = 'Manajemen Tambak';
    protected static ?string $navigationLabel = "Laporan Bulanan";

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('farm_id')
                ->relationship('farm', 'name')
                ->required(),
            Forms\Components\DatePicker::make('report_month')
            ->label('Laporan Bulanan')
            ->required(),
            Forms\Components\TextInput::make('income')->numeric()
            ->label('Pendapatan')
            ->required(),
            Forms\Components\TextInput::make('expenses')->numeric()
            ->label('Pengeluaran')
            ->required(),
            Forms\Components\TextInput::make('profit')->numeric()->required(),
            Forms\Components\Textarea::make('details')
            ->label('Rincian')
            ,
            Forms\Components\Select::make('status')
                ->options(['draft' => 'Draft', 'finalized' => 'Finalized'])
                ->default('draft')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('farm.name')->label('Farm Name'),
            Tables\Columns\TextColumn::make('report_month')->date(),
            Tables\Columns\TextColumn::make('income')->money('IDR'),
            Tables\Columns\TextColumn::make('profit')->money('IDR'),
            Tables\Columns\BadgeColumn::make('status')->colors([
                'success' => 'finalized',
                'warning' => 'draft',
            ]),
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
}
