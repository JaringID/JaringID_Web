<?php

namespace App\Http\Controllers;

use App\Models\Penyakit;

class PenyakitController extends Controller{
public function index()
{
    $penyakit = Penyakit::all()->map(function($item) {
        return [
            'id' => $item->id,
            'nama' => $item->nama,
            'deskripsi' => $item->deskripsi,
            'image' => $item->image_url // Gunakan full URL
        ];
    });
    
    return response()->json($penyakit);
}
}