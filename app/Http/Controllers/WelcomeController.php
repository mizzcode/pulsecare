<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AssesmentResult;

class WelcomeController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();

        $totalAssesments = AssesmentResult::count();

        return view('welcome', [
            'totalUsers' => $totalUsers,
            'totalAssesments' => $totalAssesments
        ]);
    }
}
