<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendapatanResource\Pages;
use App\Filament\Resources\PendapatanResource\RelationManagers;
use App\Models\Pendapatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PendapatanResource extends Resource
{
    protected static ?string $model = Pendapatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Pendapatan';
    protected static ?string $pluralLabel = 'Pendapatan';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('farms_id')
                ->label('Farm')
                ->relationship('farm', 'name')
                ->options(function () {
                    return \App\Models\Farm::where('user_id', auth()->id())
                        ->pluck('name', 'id');
                })
                ->required(),

            Forms\Components\TextInput::make('saldo')
                ->label('Saldo')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('pendapatan')
                ->label('Pendapatan')
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
                Tables\Columns\TextColumn::make('farm.name')
                ->label('Farm Name')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('saldo')
                ->label('Saldo')
                ->money('IDR') // Sesuaikan dengan mata uang Anda
                ->sortable(),

            Tables\Columns\TextColumn::make('pendapatan')
                ->label('Pendapatan')
                ->money('IDR') // Sesuaikan dengan mata uang Anda
                ->sortable(),

            Tables\Columns\TextColumn::make('tanggal')
                ->label('Tanggal')
                ->date('d M Y'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListPendapatans::route('/'),
            'create' => Pages\CreatePendapatan::route('/create'),
            'edit' => Pages\EditPendapatan::route('/{record}/edit'),
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
