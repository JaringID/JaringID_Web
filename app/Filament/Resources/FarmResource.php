<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FarmResource\Pages;
use App\Models\Farm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Resource Filament untuk manajemen data Tambak.
 */
class FarmResource extends Resource
{
    protected static ?string $model = Farm::class;

    protected static ?string $pluralLabel = 'Tambak';
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Daftar Tambak';

    /**
     * Formulir input data Tambak.
     *
     * @param Form $form
     * @return Form
     */
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Tambak')
                ->required()
                ->maxLength(255),

            Forms\Components\TextArea::make('lokasi')
                ->label('Lokasi Tambak')
                ->required()
                ->maxLength(1000),

            Forms\Components\TextArea::make('description')
                ->label('Deskripsi Tambak')
                ->nullable()
                ->maxLength(1000),

            Forms\Components\Hidden::make('user_id')
                ->default(auth()->id()),
        ]);
    }

    /**
     * Tabel daftar tambak.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Tambak')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kolam_count')
                    ->label('Jumlah Kolam')
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->kolams->count()),

                Tables\Columns\TextColumn::make('lokasi')
                    ->label('Lokasi Tambak')
                    ->limit(50),

                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi Tambak')
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime(),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * Relasi tambahan untuk resource ini.
     *
     * @return array
     */
    public static function getRelations(): array
    {
        return [
            // Tambahkan RelationManagers jika ada
        ];
    }

    /**
     * Query data terbatas hanya untuk user yang sedang login.
     *
     * @return Builder
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    /**
     * Halaman yang tersedia pada resource ini.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFarms::route('/'),
            'create' => Pages\CreateFarm::route('/create'),
            'edit' => Pages\EditFarm::route('/{record}/edit'),
        ];
    }
}
