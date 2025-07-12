<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AssesmentResult;
use App\Models\Article;

class WelcomeController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalAssesments = AssesmentResult::count();

        // Get latest 3 published articles for homepage
        $latestArticles = Article::published()
            ->with('author')
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('welcome', [
            'totalUsers' => $totalUsers,
            'totalAssesments' => $totalAssesments,
            'latestArticles' => $latestArticles
        ]);
    }
}
