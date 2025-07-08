<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AssesmentResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        $endDate = now();
        $startDate = now()->subDays(6)->startOfDay();

        $assessmentsInPeriod = AssesmentResult::where('user_id', $userId)
            ->where('created_at', '>=', $startDate)
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('Y-m-d');
            });

        $depressionData = [];
        $anxietyData = [];
        $stressData = [];

        for ($i = 6; $i >= 0; $i--) {
            $loopDate = now()->subDays($i)->startOfDay();
            $dateString = $loopDate->format('Y-m-d');

            // Cek apakah ada data asesmen pada tanggal ini
            if (isset($assessmentsInPeriod[$dateString])) {
                // Jika ada, tambahkan setiap assessment pada hari itu sebagai titik data terpisah
                foreach ($assessmentsInPeriod[$dateString] as $assessment) {
                    $depressionData[] = ['x' => $assessment->created_at->toIso8601String(), 'y' => $assessment->depression_score];
                    $anxietyData[] = ['x' => $assessment->created_at->toIso8601String(), 'y' => $assessment->anxiety_score];
                    $stressData[] = ['x' => $assessment->created_at->toIso8601String(), 'y' => $assessment->stress_score];
                }
            } else {
                // Jika tidak ada assessment di hari ini, buat satu titik dengan nilai 0
                $depressionData[] = ['x' => $loopDate->copy()->setTime(12, 0, 0)->toIso8601String(), 'y' => 0];
                $anxietyData[] = ['x' => $loopDate->copy()->setTime(12, 0, 0)->toIso8601String(), 'y' => 0];
                $stressData[] = ['x' => $loopDate->copy()->setTime(12, 0, 0)->toIso8601String(), 'y' => 0];
            }
        }

        $tableAssessments = AssesmentResult::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($assessment) {
                $levels = [
                    'Sangat Berat' => 4,
                    'Berat' => 3,
                    'Sedang' => 2,
                    'Ringan' => 1,
                    'Normal' => 0
                ];
                $levelValues = [
                    $levels[$assessment->depression_level] ?? 0,
                    $levels[$assessment->anxiety_level] ?? 0,
                    $levels[$assessment->stress_level] ?? 0,
                ];
                $highestLevelValue = max($levelValues);
                $highestLevel = array_search($highestLevelValue, $levels);

                return [
                    'id' => $assessment->id,
                    'date' => $assessment->created_at->format('d M Y H:i'),
                    'depression' => $assessment->depression_score,
                    'anxiety' => $assessment->anxiety_score,
                    'stress' => $assessment->stress_score,
                    'level' => $highestLevel,
                ];
            });

        $totalAssessments = $tableAssessments->count();
        $averageScore = $totalAssessments > 0 ? number_format(
            ($tableAssessments->sum('depression') + $tableAssessments->sum('anxiety') + $tableAssessments->sum('stress')) /
                ($totalAssessments * 3),
            2
        ) : '0.00';

        return view('assesment.history', [
            'depressionData' => $depressionData,
            'anxietyData' => $anxietyData,
            'stressData' => $stressData,
            'allAssessments' => $tableAssessments,
            'averageScore' => $averageScore,
            'totalAssessments' => $totalAssessments,
            'chartMinDate' => $startDate->toIso8601String(),
            'chartMaxDate' => $endDate->toIso8601String(),
        ]);
    }
}