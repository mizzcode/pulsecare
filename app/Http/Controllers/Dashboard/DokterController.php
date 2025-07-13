<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Jika user adalah dokter, redirect ke chat index
        if ($user->isDoctor()) {
            return redirect()->route('chat.index');
        }

        // Redirect ke halaman chat doctors yang lebih modern
        return redirect()->route('chat.doctors');
    }
}
