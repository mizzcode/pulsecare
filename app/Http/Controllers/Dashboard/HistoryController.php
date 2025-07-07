<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AssesmentResult;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Carbon\Carbon;

class HistoryController extends Controller
{
    public function index(): View
    {
        $userId = Auth::id();

        // 1. Tentukan rentang tanggal 7 hari secara eksplisit
        $endDate = now();
        $startDate = now()->subDays(6)->startOfDay(); // 7 hari termasuk hari ini

        // 2. Ambil data assesment dalam rentang tanggal tersebut
        $assessmentsForChart = AssesmentResult::where('user_id', $userId)
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->orderBy('created_at', 'asc')
            ->get();

        // 3. Buat array untuk menampung semua data assessment + data kosong untuk hari tanpa assessment
        $depressionData = [];
        $anxietyData = [];
        $stressData = [];

        // Loop untuk setiap hari dalam rentang 7 hari
        for ($i = 0; $i < 7; $i++) {
            $currentDate = $startDate->copy()->addDays($i);

            // Cari semua assessment untuk hari ini
            $dayAssessments = $assessmentsForChart->filter(function ($assessment) use ($currentDate) {
                return $assessment->created_at->isSameDay($currentDate);
            });

            // Jika ada assessment di hari ini, tambahkan semua ke chart
            if ($dayAssessments->isNotEmpty()) {
                foreach ($dayAssessments as $assessment) {
                    $dateForChart = $assessment->created_at->toIso8601String();

                    $depressionData[] = ['x' => $dateForChart, 'y' => $assessment->depression_score];
                    $anxietyData[] = ['x' => $dateForChart, 'y' => $assessment->anxiety_score];
                    $stressData[] = ['x' => $dateForChart, 'y' => $assessment->stress_score];
                }
            } else {
                // Jika tidak ada assessment di hari ini, buat titik dengan nilai 0 di tengah hari
                $dateForChart = $currentDate->copy()->setTime(12, 0, 0)->toIso8601String();

                $depressionData[] = ['x' => $dateForChart, 'y' => 0];
                $anxietyData[] = ['x' => $dateForChart, 'y' => 0];
                $stressData[] = ['x' => $dateForChart, 'y' => 0];
            }
        }

        // 4. Ambil semua data untuk ditampilkan di tabel riwayat
        $tableAssessments = AssesmentResult::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($assessment) {
                // Tentukan level terparah untuk ditampilkan di tabel
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
                    'date' => $assessment->created_at->format('d M Y H:i'),
                    'depression' => $assessment->depression_score,
                    'anxiety' => $assessment->anxiety_score,
                    'stress' => $assessment->stress_score,
                    'level' => $highestLevel,
                ];
            });

        // 5. Hitung statistik untuk summary card
        $totalAssessments = $tableAssessments->count();
        $averageScore = $totalAssessments > 0 ? number_format(
            ($tableAssessments->sum('depression') + $tableAssessments->sum('anxiety') + $tableAssessments->sum('stress')) /
                ($totalAssessments * 3),
            2
        ) : '0.00';

        // 6. Kirim data ke view, termasuk batas tanggal untuk chart
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
