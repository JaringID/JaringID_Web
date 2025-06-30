<?php

namespace App\Http\Controllers;

use App\Models\Kolam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KolamController extends Controller
{
    /**
     * Menampilkan semua kolam milik user yang login.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $kolam = Kolam::where('user_id', $user->id)->get();

        return response()->json($kolam);
    }

    /**
     * Menyimpan data kolam baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_kolam'       => 'required|string|max:255',
            'tipe_kolam'       => 'required|in:kotak,bulat',
            'kedalaman_kolam'  => 'required|numeric',
            'panjang_kolam'    => 'required_if:tipe_kolam,kotak|nullable|numeric',
            'lebar_kolam'      => 'required_if:tipe_kolam,kotak|nullable|numeric',
            'keliling_kolam'   => 'nullable|numeric',
            'diameter_kolam'   => 'required_if:tipe_kolam,bulat|nullable|numeric',
            'farm_id'          => 'required|exists:farms,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Simpan data
        $kolam = Kolam::create([
            'nama_kolam'       => $request->nama_kolam,
            'tipe_kolam'       => $request->tipe_kolam,
            'kedalaman_kolam'  => $request->kedalaman_kolam,
            'panjang_kolam'    => $request->panjang_kolam,
            'lebar_kolam'      => $request->lebar_kolam,
            'keliling_kolam'   => $request->keliling_kolam,
            'diameter_kolam'   => $request->diameter_kolam,
            'farm_id'          => $request->farm_id,
            'user_id'          => Auth::id(),
        ]);

        return response()->json([
            'message' => 'Kolam berhasil dibuat!',
            'data'    => $kolam,
        ], 201);
    }

    /**
     * Memperbarui data kolam berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $kolam = Kolam::find($id);

        if (!$kolam) {
            return response()->json(['message' => 'Kolam tidak ditemukan'], 404);
        }

        // Validasi input
        $request->validate([
            'nama_kolam'       => 'required|string|max:255',
            'tipe_kolam'       => 'required|in:kotak,bulat',
            'kedalaman_kolam'  => 'required|numeric',
            'panjang_kolam'    => 'required_if:tipe_kolam,kotak|nullable|numeric',
            'lebar_kolam'      => 'required_if:tipe_kolam,kotak|nullable|numeric',
            'keliling_kolam'   => 'nullable|numeric',
            'diameter_kolam'   => 'required_if:tipe_kolam,bulat|nullable|numeric',
        ]);

        // Update data kolam
        $kolam->update([
            'nama_kolam'       => $request->nama_kolam,
            'tipe_kolam'       => $request->tipe_kolam,
            'kedalaman_kolam'  => $request->kedalaman_kolam,
            'panjang_kolam'    => $request->panjang_kolam,
            'lebar_kolam'      => $request->lebar_kolam,
            'keliling_kolam'   => $request->keliling_kolam,
            'diameter_kolam'   => $request->diameter_kolam,
        ]);

        return response()->json([
            'message' => 'Kolam berhasil diperbarui!',
            'kolam'   => $kolam,
        ]);
    }

    /**
     * Menghapus kolam berdasarkan ID.
     */
    public function destroy($id)
    {
        $kolam = Kolam::find($id);

        if (!$kolam) {
            return response()->json(['message' => 'Kolam tidak ditemukan'], 404);
        }

        $kolam->delete();

        return response()->json(['message' => 'Kolam berhasil dihapus']);
    }
}
