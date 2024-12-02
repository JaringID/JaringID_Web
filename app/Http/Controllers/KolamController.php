<?php

namespace App\Http\Controllers;

use App\Models\Kolam;
use Illuminate\Http\Request;

class KolamController extends Controller
{
    public function index()
    {
        return Kolam::with('farm')->get();
    }
}

