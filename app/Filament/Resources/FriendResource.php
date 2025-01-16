<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FriendResource\Pages;
use App\Filament\Resources\FriendResource\RelationManagers;
use App\Models\Friend;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FriendResource extends Resource
{
    protected static ?string $model = Friend::class;
    protected static ?string $pluralLabel = 'Status Kerja';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Hidden::make('user_id')
    ->default(auth()->id()) // Isi dengan ID pengguna yang sedang login
    ->required(),



    Forms\Components\Select::make('friend_id')
    ->label('Karyawan')
    ->relationship('friend', 'name')
    ->searchable()
    ->getSearchResultsUsing(function (string $search) {
        return \App\Models\User::where('name', 'like', "%{$search}%")
            ->where('id', '!=', auth()->id())
            ->pluck('name', 'id');
    })
    ->required()
    ->placeholder('Cari username karyawan...')
    ->afterStateUpdated(function ($state, $component) {
        $friend = \App\Models\User::find($state); // Temukan karyawan berdasarkan ID
        if ($friend) {
            \App\Models\Notification::create([
                'user_id' => $friend->id,
                'message' => 'Anda dipilih oleh manajer untuk bergabung.',
            ]);
        }
    }),

            


                Forms\Components\Hidden::make('status')
                ->default('pending'), // Set default status to 'pending'
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('user.name')
                ->label('Manajer')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('friend.name')
                ->label('Karyawan')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->sortable(),
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('accept')
                ->label('Terima')
                ->action(fn (Friend $record) => $record->update(['status' => 'accepted']))
                ->requiresConfirmation()
                ->visible(fn (Friend $record) => $record->friend_id == auth()->id() && $record->status === 'pending'),

            Tables\Actions\Action::make('reject')
                ->label('Tolak')
                ->action(fn (Friend $record) => $record->update(['status' => 'rejected']))
                ->requiresConfirmation()
                ->visible(fn (Friend $record) => $record->friend_id == auth()->id() && $record->status === 'pending'),
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
    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->where(function (Builder $query) {
            $query->where('user_id', auth()->id()) // Sebagai pengirim
                  ->orWhere('friend_id', auth()->id()); // Sebagai penerima
        });
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


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFriends::route('/'),
            'create' => Pages\CreateFriend::route('/create'),
            'edit' => Pages\EditFriend::route('/{record}/edit'),
        ];
    }
}
