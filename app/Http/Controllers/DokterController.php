<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DokterController extends Controller
{
  public function index()
  {
    $doctors = User::with('role')->where('role_id', 2)->get();
    return view('dokter.index', compact('doctors'));
  }
}
