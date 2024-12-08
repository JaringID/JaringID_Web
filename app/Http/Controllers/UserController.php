<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Menampilkan profil user berdasarkan ID atau autentikasi saat ini.
     *
     * @param  int|null  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showProfile(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        // Mengembalikan data profil user
        return response()->json([
            'profile_picture' => $user->profile_picture ? 'storage/' . $user->profile_picture : null,
            'name'            => $user->name,
            'email'           => $user->email,
            'phone_number'    => $user->phone_number,
            'role'            => $user->role
        ]);
    }
}
