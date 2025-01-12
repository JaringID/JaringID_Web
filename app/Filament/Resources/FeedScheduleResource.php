<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\FeedSchedule;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FeedScheduleResource\Pages;
use App\Filament\Resources\FeedScheduleResource\RelationManagers;

class FeedScheduleResource extends Resource
{
    protected static ?string $model = FeedSchedule::class;
    protected static ?string $pluralLabel = 'Pengaturan Pakan';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen Tambak';
    protected static ?string $navigationLabel = 'Jadwal Pakan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('feed_type')
                    ->label('Jenis Pakan')
                    ->required(),

                Forms\Components\DatePicker::make('schedule_date')
                    ->label('Tanggal Pemberian Pakan')
                    ->required(),

                Forms\Components\TimePicker::make('feed_time')
                    ->label('Waktu Pemberian Pakan')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'completed' => 'Selesai',
                        'pending' => 'Tertunda',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('feed_type')
                ->sortable()
                ->searchable(),
            TextColumn::make('schedule_date')
                ->sortable(),
            TextColumn::make('feed_time')
                ->sortable(),
            TextColumn::make('status')
                ->sortable()
                ->searchable(),
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
            'index' => Pages\ListFeedSchedules::route('/'),
            'create' => Pages\CreateFeedSchedule::route('/create'),
            'edit' => Pages\EditFeedSchedule::route('/{record}/edit'),
        ];
    }
    public static function shouldRegisterNavigation(): bool
{
    // Return false untuk menghapus resource dari sidebar
    return false;
}
}
