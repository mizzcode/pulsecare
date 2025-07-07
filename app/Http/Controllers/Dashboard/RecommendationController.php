<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Recommendation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RecommendationController extends Controller
{
    /**
     * Display recommendation page based on latest assessment
     */
    public function index()
    {
        $userId = Auth::id();

        // Ambil history terakhir berdasarkan user_id
        $latestHistory = History::whereHas('assesmentResult', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->with('assesmentResult')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$latestHistory) {
            return view('recommendation.index', [
                'assessmentResult' => null
            ]);
        }
        
        $recommendations = Recommendation::byLevel($latestHistory->level)->get();
        Log::info('Recommendations', ['level' => $latestHistory->level, 'recommendations' => $recommendations]);

        $assessmentResult = $latestHistory->assesmentResult;
        Log::info('Assessment Result', [
            'user_id' => $assessmentResult->user_id,
            'score' => $latestHistory->score,
            'level' => $latestHistory->level
        ]);

        return view('recommendation.index', [
            'level' => $latestHistory->level,
            'score' => $latestHistory->score,
            'recommendations' => $recommendations,
            'assessmentDate' => $latestHistory->created_at,
            'assessmentResult' => $assessmentResult
        ]);
    }
}