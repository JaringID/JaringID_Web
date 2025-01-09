<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Http\UploadedFile;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $plurlLabel = 'Pengaturan Pengguna';

    protected static ?string $navigationIcon = 'heroicon-o-user'; // atau 'heroicon-o-identity'
    protected static ?string $navigationLabel = "Pengguna";


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255),
        
            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->required()
                ->email()
                ->maxLength(255),
        
            Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->required(fn ($livewire) => !$livewire->getRecord()) // only required on create
                ->minLength(8)
                ->maxLength(255),
        
            Forms\Components\Select::make('role')
                ->label('Role')
                ->options([
                    'farm_manager' => 'Farm Manager',
                    'employee' => 'Employee',
                ])
                ->required(),
                Forms\Components\TextInput::make('phone_number')
    ->label('Phone Number')
    ->required() // Wajib diisi
    ->maxLength(15) // Maksimal 15 karakter untuk nomor telepon
    ->numeric() // Hanya menerima angka
    ->minLength(10), // Minimal 10 digit untuk nomor telepon

    FileUpload::make('profile_picture')
    ->label('Profile Picture')
    ->disk('public') // Gunakan disk 'public'
    ->directory('profile_pictures') // Simpan file di folder 'profile_pictures'
    ->image() // Pastikan hanya file gambar yang diterima
    ->preserveFilenames() // (Opsional) Mempertahankan nama file asli
    ->required(), // Hanya jika input gambar wajib

    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('role')
                ->label('Role')
                ->sortable(),
                Tables\Columns\TextColumn::make('phone_number')
    ->label('Phone Number')
    ->sortable()
    ->searchable(),

    ImageColumn::make('profile_picture')
    ->label('Profile Picture')
    ->getStateUsing(fn($record) => $record->profile_picture_url) // Gunakan accessor yang benar
    ->width(50)
    ->height(50),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    public static function shouldRegisterNavigation(): bool
{
    // Return false untuk menghapus resource dari sidebar
    return false;
}

}
