<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AssesmentAnswer;
use App\Models\AssesmentQuestion;
use App\Models\AssesmentResult;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AssesmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $latestResult = AssesmentResult::where('user_id', $userId)->latest()->first();

        return view('assesment.index', [
            'result' => $latestResult ? true : false,
            'depressionScore' => $latestResult ? $latestResult->depression_score : 0,
            'depressionLevel' => $latestResult ? $latestResult->depression_level : '-',
            'anxietyScore' => $latestResult ? $latestResult->anxiety_score : 0,
            'anxietyLevel' => $latestResult ? $latestResult->anxiety_level : '-',
            'stressScore' => $latestResult ? $latestResult->stress_score : 0,
            'stressLevel' => $latestResult ? $latestResult->stress_level : '-',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $perPage = 7;
        $currentPage = $request->input('page', 1);
        $questions = AssesmentQuestion::orderBy('id')->skip(($currentPage - 1) * $perPage)->take($perPage)->get();
        $totalQuestions = AssesmentQuestion::count();
        $totalPages = ceil($totalQuestions / $perPage);
        $answers = AssesmentAnswer::orderBy('id')->get();

        // Ambil data dari sesi jika ada
        $sessionAnswers = $request->session()->get('assesment_answers', []);

        return view('assesment.kuisioner', [
            'questions' => $questions,
            'answers' => $answers,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'sessionAnswers' => $sessionAnswers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $answers = $request->input('answers', []);
        $userId = auth()->id();
        $currentPage = $request->input('page', 1);

        // Ambil jawaban dari sesi
        $sessionAnswers = $request->session()->get('assesment_answers', []);

        // Validasi per halaman - pastikan semua pertanyaan di halaman ini dijawab
        if (!$request->has('submit_final')) {
            $perPage = 7;
            $currentPageInt = (int) $request->input('next_page', $currentPage);
            $previousPage = $currentPageInt - 1;

            // Jika ini bukan halaman pertama dan user menekan next
            if ($previousPage > 0 && $request->input('next_page') > $currentPage) {
                $questionsOnPage = AssesmentQuestion::orderBy('id')
                    ->skip(($previousPage - 1) * $perPage)
                    ->take($perPage)
                    ->get();

                // Periksa apakah semua pertanyaan di halaman sebelumnya sudah dijawab
                foreach ($questionsOnPage as $question) {
                    if (!isset($answers[$question->id]) || $answers[$question->id] === '') {
                        return redirect()->back()
                            ->withErrors(['message' => 'Silakan jawab semua pertanyaan di halaman ini sebelum melanjutkan.'])
                            ->withInput();
                    }
                }
            }
        }

        // Merge jawaban baru dengan jawaban yang sudah ada di sesi
        // Hanya update jawaban yang benar-benar diisi di halaman ini
        foreach ($answers as $questionId => $value) {
            if ($value !== '' && $value !== null) {
                $sessionAnswers[$questionId] = $value;
            }
        }

        // Simpan kembali ke sesi
        $request->session()->put('assesment_answers', $sessionAnswers);

        // Log untuk debugging
        Log::info('Current page: ' . $currentPage);
        Log::info('Next page: ' . $request->input('next_page'));
        Log::info('Answers received: ' . json_encode($answers));
        Log::info('Session answers: ' . json_encode($sessionAnswers));

        // Validasi dan penyimpanan final hanya saat submit akhir
        if ($request->has('submit_final') && $request->input('submit_final') === 'true') {
            $totalQuestions = AssesmentQuestion::count();

            // Validasi final - pastikan semua pertanyaan sudah dijawab
            if (count($sessionAnswers) < $totalQuestions) {
                return redirect()->back()
                    ->withErrors(['message' => 'Semua pertanyaan harus diisi sebelum mengirim assessment.'])
                    ->withInput();
            }

            // Pastikan tidak ada jawaban yang kosong
            foreach ($sessionAnswers as $qId => $value) {
                if ($value === '' || $value === null) {
                    return redirect()->back()
                        ->withErrors(['message' => 'Semua pertanyaan harus diisi sebelum mengirim assessment.'])
                        ->withInput();
                }
            }

            // Ambil semua questions untuk mendapatkan mapping yang benar
            $questions = AssesmentQuestion::orderBy('id')->get();

            // Buat mapping berdasarkan urutan pertanyaan (1-based ke 0-based)
            $questionMapping = [];
            foreach ($questions as $index => $question) {
                $questionMapping[$index] = $question->id;
            }

            // Indeks pertanyaan berdasarkan kategori DASS-21 (0-based index berdasarkan urutan)
            $depressionIdx = [2, 4, 9, 12, 15, 16, 20]; // Pertanyaan ke-3, 5, 10, 13, 16, 17, 21
            $anxietyIdx = [1, 3, 6, 8, 14, 18, 19];     // Pertanyaan ke-2, 4, 7, 9, 15, 19, 20
            $stressIdx = [0, 5, 7, 10, 11, 13, 17];     // Pertanyaan ke-1, 6, 8, 11, 12, 14, 18

            $depressionScore = $this->calculateScore($sessionAnswers, $depressionIdx, $questionMapping);
            $anxietyScore = $this->calculateScore($sessionAnswers, $anxietyIdx, $questionMapping);
            $stressScore = $this->calculateScore($sessionAnswers, $stressIdx, $questionMapping);

            $depressionLevel = $this->getCategory('depression', $depressionScore);
            $anxietyLevel = $this->getCategory('anxiety', $anxietyScore);
            $stressLevel = $this->getCategory('stress', $stressScore);

            // Log hasil perhitungan
            Log::info("Final Scores - Depression: $depressionScore, Anxiety: $anxietyScore, Stress: $stressScore");
            Log::info("Final Categories - Depression: $depressionLevel, Anxiety: $anxietyLevel, Stress: $stressLevel");

            // Simpan ke tabel assesment_results
            $assesmentResult = AssesmentResult::create([
                'depression_score' => $depressionScore,
                'depression_level' => $depressionLevel,
                'anxiety_score' => $anxietyScore,
                'anxiety_level' => $anxietyLevel,
                'stress_score' => $stressScore,
                'stress_level' => $stressLevel,
                'user_id' => $userId,
            ]);

            Log::info("AssesmentResult created: " . $assesmentResult);

            $score = $depressionScore + $anxietyScore + $stressScore;
            Log::info("Total Score: $score");

            $levels = [$depressionLevel, $anxietyLevel, $stressLevel];
            $severityOrder = ['Normal', 'Ringan', 'Sedang', 'Berat', 'Sangat Berat'];

            $highestLevel = 'Normal';
            foreach ($levels as $level) {
                if (array_search($level, $severityOrder) > array_search($highestLevel, $severityOrder)) {
                    $highestLevel = $level;
                }
            }

            History::create([
                'score' => $score,
                'level' => $highestLevel, 
                'assesment_result_id' => $assesmentResult->id,
            ]);

            // Hapus sesi setelah submit
            $request->session()->forget('assesment_answers');

            // Redirect ke index untuk melihat hasil
            return redirect()->route('kuisioner.index')->with('success', 'Assessment berhasil disimpan!');
        }

        // Redirect ke halaman berikutnya atau sebelumnya
        $nextPage = $request->input('next_page', $currentPage);
        return redirect()->route('kuisioner.create', ['page' => $nextPage]);
    }

    /**
     * Calculate score based on question indices with proper mapping
     */
    private function calculateScore($answers, $indices, $questionMapping)
    {
        Log::info('Calculating score for indices: ' . implode(', ', $indices));
        Log::info('Question mapping: ' . json_encode($questionMapping));
        Log::info('Session answers: ' . json_encode($answers));

        $totalScore = 0;
        foreach ($indices as $index) {
            $questionId = $questionMapping[$index];
            $value = isset($answers[$questionId]) ? (int)$answers[$questionId] : 0;
            $totalScore += $value;
            Log::info("Index: $index, Question ID: $questionId, Original Value: $value");
        }

        Log::info("Total score after doubling each value: $totalScore");
        return $totalScore;
    }

    /**
     * Determine category based on score
     */
    private function getCategory($type, $score)
    {
        Log::info("Calculating category for type: $type, final score: $score");

        switch ($type) {
            case 'depression':
                if ($score <= 4) return 'Normal';
                if ($score <= 6) return 'Ringan';
                if ($score <= 10) return 'Sedang';
                if ($score <= 13) return 'Berat';
                return 'Sangat Berat';
            case 'anxiety':
                if ($score <= 3) return 'Normal';
                if ($score <= 5) return 'Ringan';
                if ($score <= 7) return 'Sedang';
                if ($score <= 9) return 'Berat';
                return 'Sangat Berat';
            case 'stress':
                if ($score <= 7) return 'Normal';
                if ($score <= 9) return 'Ringan';
                if ($score <= 12) return 'Sedang';
                if ($score <= 16) return 'Berat';
                return 'Sangat Berat';
            default:
                return '-';
        }
    }
}