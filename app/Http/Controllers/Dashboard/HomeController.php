<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AssesmentResult;
use App\Models\Chat;
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

        // Chat statistics based on user role
        $user = $request->user();
        $activeChats = 0;
        $unreadMessages = 0;

        if ($user->isDoctor()) {
            // For doctors: count active chats with patients
            $activeChats = Chat::where('doctor_id', $user->id)
                ->where('status', 'active')
                ->count();

            // Count unread messages from patients
            $unreadMessages = Chat::where('doctor_id', $user->id)
                ->where('status', 'active')
                ->withCount(['messages as unread_count' => function ($query) use ($user) {
                    $query->where('sender_id', '!=', $user->id)
                        ->where('is_read', false);
                }])
                ->get()
                ->sum('unread_count');
        } else {
            // For patients: count active chats with doctors
            $activeChats = Chat::where('patient_id', $user->id)
                ->where('status', 'active')
                ->count();

            // Count unread messages from doctors
            $unreadMessages = Chat::where('patient_id', $user->id)
                ->where('status', 'active')
                ->withCount(['messages as unread_count' => function ($query) use ($user) {
                    $query->where('sender_id', '!=', $user->id)
                        ->where('is_read', false);
                }])
                ->get()
                ->sum('unread_count');
        }

        return view('dashboard', [
            'totalUsers' => User::count(),
            'user' => $request->user(),
            'usersThisMonth' => $usersThisMonth,
            'percentageChange' => $percentageChange,
            'totalAssessments' => $totalAssessments,
            'latestLevel' => $latestLevel,
            'activeChats' => $activeChats,
            'unreadMessages' => $unreadMessages,
        ]);
    }
}
