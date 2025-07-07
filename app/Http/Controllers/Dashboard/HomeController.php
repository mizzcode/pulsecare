<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AssesmentResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $usersThisMonth = User::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        $usersLastMonth = User::whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth(),
        ])->count();

        $percentageChange = null;
        if ($usersLastMonth > 0) {
            $percentageChange = (($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100;
        } elseif ($usersThisMonth > 0) {
            $percentageChange = 100;
        }

        $totalAssessments = AssesmentResult::where('user_id', $request->user()->id)->count();
        $latestAssessment = AssesmentResult::where('user_id', $request->user()->id)->latest()->first();
        $latestLevel = $latestAssessment ? max([$latestAssessment->depression_level, $latestAssessment->anxiety_level, $latestAssessment->stress_level]) : null;

        return view('dashboard', [
            'totalUsers' => User::count(),
            'user' => $request->user(),
            'usersThisMonth' => $usersThisMonth,
            'percentageChange' => $percentageChange,
            'totalAssessments' => $totalAssessments,
            'latestLevel' => $latestLevel,
        ]);
    }
}
