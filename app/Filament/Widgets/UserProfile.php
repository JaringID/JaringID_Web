<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Widget
{
    protected static string $view = 'filament.widgets.user-profile';

    public function getData(): array
{
    $user = Auth::guard('web')->user();

    return [
        'name' => $user->name ?? 'Guest',
        'email' => $user->email ?? 'Email tidak tersedia',
        'role' => $user->role ?? 'Role tidak tersedia',
        'profile_picture' => $user->profile_picture ? 'storage/' . $user->profile_picture : null,
    ];
}
}
