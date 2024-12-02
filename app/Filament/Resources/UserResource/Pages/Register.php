<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Illuminate\Support\Facades\Hash;

class Register extends CreateRecord
{
    protected static string $resource = \App\Filament\Resources\UserResource::class;

    protected function getFormSchema(): array
    {
        return [
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
                ->required()
                ->minLength(8)
                ->maxLength(255),

            Forms\Components\Select::make('role')
                ->label('Role')
                ->options([
                    'farm_manager' => 'Farm Manager',
                    'employee' => 'Employee',
                ])
                ->required(),

            Forms\Components\FileUpload::make('profile_picture')
                ->label('Profile Picture')
                ->image()
                ->directory('profile_pictures')
                ->disk('public')
                ->nullable(),
        ];
    }

    protected function handleRecordCreation(array $data): User
    {
        $data['password'] = Hash::make($data['password']); // Hash password before saving
        return User::create($data); // Create user record in the database
    }

    protected function getActions(): array
    {
        return [
            Actions\Action::make('submit')
                ->label('Register')
                ->action(fn () => $this->handleRecordCreation($this->form->getState()))
                ->color('primary'),
        ];
    }
}
