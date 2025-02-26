<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Penyakit;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Http\UploadedFile;
use App\Filament\Resources\PenyakitResource\Pages;

class PenyakitResource extends Resource
{
    protected static ?string $model = Penyakit::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Penyakit';
    protected static ?string $pluralLabel = 'Penyakit';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->label('Nama Penyakit'),
                    FileUpload::make('image')
    ->label('Foto Penyakit')
    ->image()
    ->directory('penyakit-images') // Folder penyimpanan
    ->disk('public') // Pastikan menggunakan disk public
    ->required(),


                Textarea::make('deskripsi')
                    ->label('Deskripsi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Nama Penyakit'),
                ImageColumn::make('image')
    ->label('Foto Penyakit')
    ->getStateUsing(fn($record) => $record->image_url) // Menggunakan accessor
    ->width(50)
    ->height(50),
                TextColumn::make('deskripsi')->label('Deskripsi')->limit(50),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function canCreate(): bool
{
    $user = auth()->user();
    return in_array($user->role, ['owner', 'farm_manager']);
}

public static function canEdit($record): bool {
    $user = auth()->user();
    return in_array($user->role, ['owner', 'farm_manager']);
}

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenyakits::route('/'),
            'create' => Pages\CreatePenyakit::route('/create'),
            'edit' => Pages\EditPenyakit::route('/{record}/edit'),
        ];
    }
}
