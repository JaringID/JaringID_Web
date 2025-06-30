<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use Illuminate\Http\Request;

class TambakController extends Controller
{
    /**
     * Menyimpan data tambak (farm) baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'kolam'       => 'nullable|integer|min:0',
            'lokasi'      => 'required|string',
            'description' => 'nullable|string',
        ]);

        $farm = new Farm();
        $farm->name        = $validated['name'];
        $farm->kolam       = $validated['kolam'] ?? 0;
        $farm->lokasi      = $validated['lokasi'];
        $farm->description = $validated['description'] ?? '';
        $farm->user_id     = auth()->id();
        $farm->save();

        return response()->json([
            'message' => 'Tambak berhasil dibuat!',
            'data'    => $farm,
        ], 201);
    }

    /**
     * Menampilkan semua tambak milik user yang login.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $tambaks = Farm::where('user_id', $user->id)->get();

        return response()->json($tambaks);
    }

    /**
     * Mendapatkan tambak berdasarkan user login (duplikat dari index, tapi bisa untuk endpoint khusus).
     */
    public function getUserTambaks(Request $request)
    {
        $user = $request->user();
        $tambaks = Farm::where('user_id', $user->id)->get();

        return response()->json([
            'message' => 'Data tambak berdasarkan user berhasil diambil.',
            'data'    => $tambaks,
        ]);
    }
}
