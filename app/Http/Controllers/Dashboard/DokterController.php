<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $doctors = User::where('role_id', 2)->get();

        return view('dokter.index', compact('doctors'));
    }
}