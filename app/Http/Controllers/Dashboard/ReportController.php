<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AssesmentResult;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Article;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{

    public function index()
    {
        // Statistik Umum
        $totalUsers = User::count();
        $totalDoctors = User::whereHas('role', function ($q) {
            $q->where('name', 'dokter');
        })->count();
        $totalPatients = User::whereHas('role', function ($q) {
            $q->where('name', 'pasien');
        })->count();
        $totalAssessments = AssesmentResult::count();
        $totalChats = Chat::count();
        $totalArticles = Article::count();

        // Data User per Bulan (12 bulan terakhir)
        $months = [];
        $userCounts = [];
        $assessmentCounts = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthYear = $date->format('M Y');
            $months[] = $monthYear;

            // Count users for this month
            $userCount = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $userCounts[] = $userCount;

            // Count assessments for this month
            $assessmentCount = AssesmentResult::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $assessmentCounts[] = $assessmentCount;
        }

        // Data User per Bulan (untuk kompatibilitas dengan view lama)
        $userRegistrations = collect();
        $assessmentsByMonth = collect();

        // Distribusi Gender
        $genderDistribution = User::whereHas('role', function ($q) {
            $q->where('name', 'pasien');
        })
            ->select('gender', DB::raw('COUNT(*) as total'))
            ->whereNotNull('gender')
            ->groupBy('gender')
            ->get();

        // Top 5 Level Stress/Anxiety/Depression
        $stressLevels = AssesmentResult::select('stress_level', DB::raw('COUNT(*) as total'))
            ->whereNotNull('stress_level')
            ->groupBy('stress_level')
            ->orderBy('total', 'desc')
            ->get();

        $anxietyLevels = AssesmentResult::select('anxiety_level', DB::raw('COUNT(*) as total'))
            ->whereNotNull('anxiety_level')
            ->groupBy('anxiety_level')
            ->orderBy('total', 'desc')
            ->get();

        $depressionLevels = AssesmentResult::select('depression_level', DB::raw('COUNT(*) as total'))
            ->whereNotNull('depression_level')
            ->groupBy('depression_level')
            ->orderBy('total', 'desc')
            ->get();

        // Activity Chat per Bulan
        $chatActivity = ChatMessage::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Artikel paling banyak dilihat
        $popularArticles = Article::with('category')
            ->orderBy('views', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.reports.index', compact(
            'totalUsers',
            'totalDoctors',
            'totalPatients',
            'totalAssessments',
            'totalChats',
            'totalArticles',
            'months',
            'userCounts',
            'assessmentCounts',
            'userRegistrations',
            'assessmentsByMonth',
            'genderDistribution',
            'stressLevels',
            'anxietyLevels',
            'depressionLevels',
            'chatActivity',
            'popularArticles'
        ));
    }

    public function users(Request $request)
    {
        $query = User::with('role')->select('users.*');

        // Filter berdasarkan search (nama atau email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan role
        if ($request->filled('role')) {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        // Preserve query parameters for pagination
        $users->appends($request->query());

        // Statistik tambahan untuk halaman user
        $usersByRole = Role::withCount('users')
            ->orderBy('name')
            ->get()
            ->map(function ($role) {
                return (object) [
                    'role_name' => $role->name,
                    'total' => $role->users_count
                ];
            })
            ->filter(function ($role) {
                return $role->total > 0; // Only show roles that have users
            });

        return view('dashboard.reports.users', compact(
            'users',
            'usersByRole'
        ));
    }

    public function assessments()
    {
        $assessments = AssesmentResult::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Statistik level kesehatan mental
        $mentalHealthStats = [
            'stress' => AssesmentResult::select('stress_level', DB::raw('COUNT(*) as total'))
                ->whereNotNull('stress_level')
                ->groupBy('stress_level')
                ->get(),
            'anxiety' => AssesmentResult::select('anxiety_level', DB::raw('COUNT(*) as total'))
                ->whereNotNull('anxiety_level')
                ->groupBy('anxiety_level')
                ->get(),
            'depression' => AssesmentResult::select('depression_level', DB::raw('COUNT(*) as total'))
                ->whereNotNull('depression_level')
                ->groupBy('depression_level')
                ->get()
        ];

        // User dengan asesmen terbanyak
        $activeUsers = AssesmentResult::select('user_id', DB::raw('COUNT(*) as total_assessments'))
            ->with('user')
            ->groupBy('user_id')
            ->orderBy('total_assessments', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.reports.assessments', compact(
            'assessments',
            'mentalHealthStats',
            'activeUsers'
        ));
    }

    public function chats()
    {
        $chats = Chat::with(['patient', 'doctor', 'messages'])
            ->withCount('messages')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Statistik chat
        $chatStats = [
            'total_chats' => Chat::count(),
            'active_chats' => Chat::where('status', 'active')->count(),
            'closed_chats' => Chat::where('status', 'closed')->count(),
            'total_messages' => ChatMessage::count()
        ];

        // Dokter paling aktif
        $activeDoctors = ChatMessage::join('users', 'chat_messages.sender_id', '=', 'users.id')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.name', 'dokter')
            ->select('users.name', 'users.id', DB::raw('COUNT(*) as total_messages'))
            ->groupBy('users.id', 'users.name')
            ->orderBy('total_messages', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.reports.chats', compact(
            'chats',
            'chatStats',
            'activeDoctors'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'users');
        $format = $request->get('format', 'csv');

        switch ($type) {
            case 'users':
                return $this->exportUsers($format);
            case 'assessments':
                return $this->exportAssessments($format);
            case 'chats':
                return $this->exportChats($format);
            default:
                return redirect()->back()->with('error', 'Tipe export tidak valid');
        }
    }

    private function exportUsers($format)
    {
        $users = User::with('role')->get();

        if ($format === 'csv') {
            $filename = 'users_report_' . date('Y-m-d') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($users) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Nama', 'Email', 'Role', 'Gender', 'Telepon', 'Tanggal Daftar']);

                foreach ($users as $user) {
                    fputcsv($file, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->role->name,
                        $user->gender ?? '-',
                        $user->phone ?? '-',
                        $user->created_at->format('Y-m-d H:i:s')
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return redirect()->back()->with('error', 'Format export tidak didukung');
    }

    private function exportAssessments($format)
    {
        $assessments = AssesmentResult::with('user')->get();

        if ($format === 'csv') {
            $filename = 'assessments_report_' . date('Y-m-d') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($assessments) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'User', 'Stress Level', 'Anxiety Level', 'Depression Level', 'Total Score', 'Tanggal']);

                foreach ($assessments as $assessment) {
                    fputcsv($file, [
                        $assessment->id,
                        $assessment->user->name,
                        $assessment->stress_level ?? '-',
                        $assessment->anxiety_level ?? '-',
                        $assessment->depression_level ?? '-',
                        $assessment->total_score ?? '-',
                        $assessment->created_at->format('Y-m-d H:i:s')
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return redirect()->back()->with('error', 'Format export tidak didukung');
    }

    private function exportChats($format)
    {
        $chats = Chat::with(['patient', 'doctor', 'messages'])->withCount('messages')->get();

        if ($format === 'csv') {
            $filename = 'chats_report_' . date('Y-m-d') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $callback = function () use ($chats) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Patient', 'Doctor', 'Status', 'Total Messages', 'Tanggal']);

                foreach ($chats as $chat) {
                    fputcsv($file, [
                        $chat->id,
                        $chat->patient->name ?? '-',
                        $chat->doctor->name ?? '-',
                        $chat->status,
                        $chat->messages_count,
                        $chat->created_at->format('Y-m-d H:i:s')
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return redirect()->back()->with('error', 'Format export tidak didukung');
    }
}
