<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SiklusResource\Pages;
use App\Models\Siklus;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\BadgeColumn;
use App\Models\Kolam;

class SiklusResource extends Resource
{
    protected static ?string $model = Siklus::class;
    protected static ?string $navigationLabel = 'Siklus';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([ 
                Card::make()->schema([
                    Select::make('farm_id')
                        ->label('Farm')
                        ->relationship('farm', 'name')
                        ->required(),

                    Select::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name')
                        ->required(),

                        Select::make('kolam_id')
                        ->label('Kolam')
                        ->relationship('kolam', 'nama_kolam')
                        ->required()
                        ->afterStateUpdated(function ($state) {
                            $kolam = Kolam::find($state);
                            if ($kolam) {
                                $kolam->update(['status' => 'aktif']);
                            }
                        }),

                    TextInput::make('total_tebar')
                        ->label('Total Tebar')
                        ->numeric()
                        ->required(),

                    Select::make('tipe_tebar')
                        ->label('Tipe Tebar')
                        ->options([
                            'netto' => 'Netto',
                            'bruto' => 'Bruto',
                            'aktual' => 'Aktual',
                        ])
                        ->required(),

                    DatePicker::make('tanggal_tebar')
                        ->label('Tanggal Tebar')
                        ->required(),
                ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('farm.name')
                    ->label('Farm')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kolam.nama_kolam')
                    ->label('Kolam')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('total_tebar')
                    ->label('Total Tebar')
                    ->sortable(),

                TextColumn::make('tanggal_tebar')
                    ->label('Tanggal Tebar')
                    ->date()
                    ->sortable(),

                    BadgeColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(function ($record) {
                        // Cek apakah hasil panen tersedia
                        $hasilPanen = $record->hasilPanen()->latest()->first();
                
                        if ($hasilPanen) {
                            return match ($hasilPanen->jenis_panen) {
                                'Total' => 'Berhenti',
                                'Parsial' => 'Sedang Berjalan',
                                default => 'Sedang Berjalan',
                            };
                        }

                        return 'Sedang Berjalan'; // Default status jika tidak ada hasil panen
                    })
                    ->colors([
                        'success' => 'Sedang Berjalan',
                        'warning' => 'Berhenti',
                    ]),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
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
            // Tambahkan relasi jika ada
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSikluses::route('/'),
            'create' => Pages\CreateSiklus::route('/create'),
            'edit' => Pages\EditSiklus::route('/{record}/edit'),
        ];
    }
}
