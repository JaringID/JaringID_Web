<?php
namespace App\Http\Controllers;

use App\Models\Farm; // Pastikan ini adalah model Farm, bukan Tambak
use Illuminate\Http\Request;

class TambakController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data yang masuk
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'kolam' => 'required|integer|min:1',
            'description' => 'nullable|string', // Pastikan ini nullable jika tidak wajib
        ]);

        // Menyimpan data tambak baru menggunakan model Farm
        $farm = new Farm(); // Gunakan model Farm di sini
        $farm->name = $validated['name'];
        $farm->kolam = $validated['kolam'];
        $farm->description = $validated['description'] ?? ''; // Jika tidak ada deskripsi, isi dengan string kosong
        $farm->user_id = auth()->user()->id; // Menetapkan user_id sesuai user yang sedang login
        $farm->save();

        // Mengembalikan respons sukses
        return response()->json([
            'message' => 'Tambak berhasil dibuat!',
            'data' => $farm // Kembalikan data farm yang telah disimpan
        ], 201); // Status HTTP 201 Created
    }
}
