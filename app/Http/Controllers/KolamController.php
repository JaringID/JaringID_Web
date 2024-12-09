<?php

namespace App\Http\Controllers;

use App\Models\Kolam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KolamController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

         // Tampilkan kolam berdasarkan user yang login
         return Kolam::with('farm')
             ->where('user_id', $userId)
             ->get();

    }
}

