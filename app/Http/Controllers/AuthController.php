<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login untuk API mobile.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password tidak sesuai.'],
            ]);
        }

        if (!in_array($user->role, ['employee', 'farm_manager', 'owner', 'technician'])) {
            return response()->json([
                'message' => 'Akses tidak diizinkan untuk role ini.',
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token'   => $token,
            'user'    => $user,
        ], 200);
    }

    /**
     * Login untuk web admin (Filament).
     */
    public function web_login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password tidak sesuai.'],
            ]);
        }

        if (!in_array($user->role, ['employee', 'farm_manager', 'owner', 'technician'])) {
            return response()->json([
                'message' => 'Akses tidak diizinkan untuk role ini.',
            ], 403);
        }

        $user->createToken('auth_token'); // token tidak dikirim, hanya validasi login

        return redirect()->route('filament.admin.pages.dashboard')
            ->with('success', 'Berhasil Login.');
    }

    /**
     * Registrasi user baru.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email'        => 'required|email|unique:users,email|max:255',
            'password'     => 'required|min:8|confirmed',
            'role'         => 'required|in:owner,employee,technician',
        ]);

        User::create([
            'name'         => $data['name'],
            'phone_number' => $data['phone_number'],
            'email'        => $data['email'],
            'password'     => Hash::make($data['password']),
            'role'         => $data['role'],
        ]);

        return redirect('/admin/login')
            ->with('success', 'Akun berhasil dibuat! Silakan login.');
    }
}