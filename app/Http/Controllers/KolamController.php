<?php
namespace App\Http\Controllers;

use App\Models\Kolam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KolamController extends Controller
{
    public function index(Request $request)
{
    $user = $request->user(); // Mendapatkan pengguna yang sedang login
    $kolam = Kolam::where('user_id', $user->id)->get(); // Filter berdasarkan user_id
    return response()->json($kolam);
}

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kolam' => 'required|string|max:255',
            'tipe_kolam' => 'required|in:kotak,bulat',
            'kedalaman_kolam' => 'required|numeric',
            'panjang_kolam' => 'required_if:tipe_kolam,kotak|nullable|numeric',
            'lebar_kolam' => 'required_if:tipe_kolam,kotak|nullable|numeric',
            'keliling_kolam' => 'nullable|numeric',
            'diameter_kolam' => 'required_if:tipe_kolam,bulat|nullable|numeric',
            'farm_id' => 'required|exists:farms,id',
           
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $userId = Auth::id();

        $kolam = Kolam::create([
            'nama_kolam' => $request->nama_kolam,
            'tipe_kolam' => $request->tipe_kolam,
            'kedalaman_kolam' => $request->kedalaman_kolam,
            'panjang_kolam' => $request->panjang_kolam,
            'lebar_kolam' => $request->lebar_kolam,
            'keliling_kolam' => $request->keliling_kolam,
            'diameter_kolam' => $request->diameter_kolam,
            'farm_id' => $request->farm_id,

        ]);

        return response()->json([
            'message' => 'Kolam berhasil dibuat!',
            'data' => $kolam
        ], 201);
    }
    public function update(Request $request, $id)
{
    $kolam = Kolam::find($id);
    if (!$kolam) {
        return response()->json(['message' => 'Kolam not found'], 404);
    }

    // Validasi data yang dikirim
    $request->validate([
        'nama_kolam' => 'required|string|max:255',
        // Tambahkan validasi lain sesuai dengan kebutuhan
    ]);

    // Update data kolam
    $kolam->nama_kolam = $request->input('nama_kolam');
    // Perbarui atribut lainnya jika diperlukan
    $kolam->save();

    return response()->json(['message' => 'Kolam updated successfully', 'kolam' => $kolam]);
}
public function destroy($id)
{
    $kolam = Kolam::find($id);
    if (!$kolam) {
        return response()->json(['message' => 'Kolam not found'], 404);
    }

    // Hapus kolam
    $kolam->delete();

    return response()->json(['message' => 'Kolam deleted successfully']);
}


}