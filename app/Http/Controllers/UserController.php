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

    /**
     * Mendapatkan data pengguna yang sedang login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(Request $request)
    {
        // Ambil pengguna yang sedang login
        $user = $request->user();

        // Periksa apakah pengguna ditemukan
        if (!$user) {
            return response()->json([
                'message' => 'User not authenticated.',
            ], 401);
        }

        // Mengembalikan data pengguna
        return response()->json([
            'message' => 'User retrieved successfully.',
            'data'    => [
                'id'              => $user->id,
                'name'            => $user->name,
                'email'           => $user->email,
                'phone_number'    => $user->phone_number,
                'role'            => $user->role,
                'farm_id'         => $user->farm_id,
                'profile_picture' => $user->getProfilePictureUrlAttribute(),
                'created_at'      => $user->created_at,
                'updated_at'      => $user->updated_at,
            ],
        ]);
    }
}
