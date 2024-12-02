<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class UserProfile extends Widget
{
    protected static string $view = 'filament.widgets.user-profile';

    public function getData(): array
    {
        $user = auth()->user();

        return [
            'name' => $user->name ?? 'Guest',
            'email' => $user->email ?? 'Email tidak tersedia',
            'role' => $user->role ?? 'Role tidak tersedia',
            'profile_picture' => $user->profile_picture ?? null,
        ];
    }
}
