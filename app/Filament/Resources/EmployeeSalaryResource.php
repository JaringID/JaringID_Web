<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\EmployeeSalary;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeSalaryResource\Pages;
use App\Filament\Resources\EmployeeSalaryResource\RelationManagers;

class EmployeeSalaryResource extends Resource
{
    protected static ?string $model = EmployeeSalary::class;
    protected static ?string $pluralLabel = 'Gaji Karyawan';

    protected static ?string $navigationIcon = 'heroicon-o-user-group'; // atau 'heroicon-o-briefcase'

    protected static ?string $navigationLabel = 'Gaji Karyawan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Manajer/Karyawan')
                    ->options(User::all()->pluck('name', 'id'))
                    ->required(),
                TextInput::make('salary_amount')
                    ->label('Jumlah Gaji')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Nama Manajer/Karyawan'),
                TextColumn::make('salary_amount')->label('Jumlah Gaji'),
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
            'index' => Pages\ListEmployeeSalaries::route('/'),
            'create' => Pages\CreateEmployeeSalary::route('/create'),
            'edit' => Pages\EditEmployeeSalary::route('/{record}/edit'),
        ];
    }
    public static function shouldRegisterNavigation(): bool
{
    // Return false untuk menghapus resource dari sidebar
    return false;
}
}
