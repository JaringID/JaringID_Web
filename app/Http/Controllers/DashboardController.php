<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
        } else {
            return redirect()->route('login'); // Arahkan kembali ke login jika tidak terautentikasi
        }

        return view('dashboard', compact('user'));
    }
}
