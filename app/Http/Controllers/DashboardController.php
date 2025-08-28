<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Budget;
use App\Models\Expense;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $currentMonth = $request->get('month', now()->month);
        $currentYear = now()->year;
        
        // Get current month's data
        $monthStart = Carbon::create($currentYear, $currentMonth, 1)->startOfMonth();
        $monthEnd = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();
        
        // Get tasks for current month
        $tasks = Task::where('user_id', auth()->id())
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->get();

        // Get budgets for current month
        $budgets = Budget::where('user_id', auth()->id())
            ->where('year', $currentYear)
            ->where('month', $currentMonth)
            ->get();

        // Get expenses for current month
        $expenses = \App\Models\Expense::where('user_id', auth()->id())
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->get();
        
        // Calculate comprehensive totals
        $totalIncome = $tasks->where('status', 'paid')->sum('amount');
        $pendingPayments = $tasks->where('status', 'pending')->sum('amount');
        $totalBudgeted = $budgets->sum('budgeted_amount');
        $totalActualSpent = $budgets->sum('actual_amount');
        $totalExpenses = $expenses->sum('amount');
        $budgetVariance = $totalBudgeted - $totalActualSpent;
        $actualBalance = $totalIncome - $totalActualSpent - $totalExpenses;
        $balance = $totalIncome - $totalActualSpent;
        
        // Calculate monthly growth (compare with previous month)
        $prevMonth = date('Y-m', strtotime($currentMonth . '-01 -1 month'));
        $prevMonthParts = explode('-', $prevMonth);
        $prevTasks = Task::where('user_id', auth()->id())
            ->whereYear('date', $prevMonthParts[0])
            ->whereMonth('date', $prevMonthParts[1])
            ->get();
        
        $prevMonthIncome = $prevTasks->where('status', 'paid')->sum('amount');
        $incomeGrowth = $prevMonthIncome > 0 ? (($totalIncome - $prevMonthIncome) / $prevMonthIncome) * 100 : 0;

        // Get employer breakdown with detailed analytics
        $employerAnalytics = [];
        $employers = ['MACFLEX', 'JUJA', 'MERU'];
        foreach ($employers as $employer) {
            $employerTasks = $tasks->where('employer', $employer);
            $employerPrevTasks = $prevTasks->where('employer', $employer);
            
            $currentIncome = $employerTasks->where('status', 'paid')->sum('amount');
            $prevIncome = $employerPrevTasks->where('status', 'paid')->sum('amount');
            $growth = $prevIncome > 0 ? (($currentIncome - $prevIncome) / $prevIncome) * 100 : 0;
            
            $employerAnalytics[$employer] = [
                'income' => $currentIncome,
                'pending' => $employerTasks->where('status', 'pending')->sum('amount'),
                'tasks_count' => $employerTasks->count(),
                'pages_count' => $employerTasks->sum('pages'),
                'avg_rate' => $employerTasks->avg('rate') ?? 0,
                'growth' => $growth,
                'last_task_date' => $employerTasks->max('date')
            ];
        }

        // Create employer income data for charts
        $employerIncome = collect($employers)->map(function($employer) use ($employerAnalytics) {
            return (object) [
                'employer' => $employer,
                'total' => $employerAnalytics[$employer]['income'] ?? 0
            ];
        });

        // Get recent activities (tasks, budgets, expenses)
        $recentTasks = $tasks->take(5);
        $recentBudgets = $budgets->sortByDesc('updated_at')->take(3);
        $recentExpenses = $expenses->sortByDesc('date')->take(5);
        
        // Expense categories breakdown
        $expenseCategories = $expenses->groupBy('category')->map(function($categoryExpenses) {
            return [
                'total' => $categoryExpenses->sum('amount'),
                'count' => $categoryExpenses->count(),
                'necessary' => $categoryExpenses->where('necessary', 'Yes')->sum('amount'),
                'optional' => $categoryExpenses->where('necessary', 'No')->sum('amount')
            ];
        });
        
        // Performance metrics
        $metrics = [
            'total_tasks_this_month' => $tasks->count(),
            'total_pages_this_month' => $tasks->sum('pages'),
            'average_task_value' => $tasks->count() > 0 ? $tasks->avg('amount') : 0,
            'completion_rate' => $tasks->count() > 0 ? ($tasks->where('status', 'paid')->count() / $tasks->count()) * 100 : 0,
            'budget_adherence' => $totalBudgeted > 0 ? (($totalBudgeted - $totalActualSpent) / $totalBudgeted) * 100 : 0,
            'income_target_progress' => 50000, // You can make this configurable
            'days_in_month' => date('t', strtotime($currentMonth . '-01')),
            'current_day' => date('j'),
        ];
        
        // Calculate daily average and projections
        $daysElapsed = $currentYear == date('Y') && $currentMonth == date('n') ? date('j') : $metrics['days_in_month'];
        $metrics['daily_average'] = $daysElapsed > 0 ? $totalIncome / $daysElapsed : 0;
        $metrics['projected_monthly'] = $metrics['daily_average'] * $metrics['days_in_month'];
        
        // Chart data for frontend
        $chartData = [
            'employer_income' => array_values(array_map(fn($emp) => $emp['income'], $employerAnalytics)),
            'employer_labels' => $employers,
            'budget_categories' => $budgets->groupBy('category')->map(fn($group) => $group->sum('budgeted_amount'))->toArray(),
            'monthly_trend' => $this->getMonthlyTrend(auth()->id(), 6), // Last 6 months
        ];

        return view('dashboard', compact(
            'totalIncome',
            'totalActualSpent',
            'totalExpenses',
            'actualBalance',
            'balance',
            'pendingPayments',
            'totalBudgeted',
            'budgetVariance',
            'budgets',
            'expenses',
            'recentExpenses',
            'expenseCategories',
            'employerIncome',
            'employerAnalytics',
            'recentTasks',
            'recentBudgets',
            'currentMonth',
            'metrics',
            'chartData',
            'incomeGrowth'
        ));
    }
    
    public function getDashboardData(Request $request)
    {
        $user = Auth::user();
        $currentMonth = $request->get('month', now()->format('Y-m'));
        $monthParts = explode('-', $currentMonth);
        $year = $monthParts[0];
        $month = $monthParts[1];

        $tasks = Task::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        $budgets = Budget::where('user_id', $user->id)
            ->where('year', $year)
            ->where('month', $month)
            ->get();

        $currentYear = now()->year;
        
        $monthStart = Carbon::create($currentYear, $currentMonth, 1)->startOfMonth();
        $monthEnd = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();
        
        $data = [
            'totalIncome' => Task::where('user_id', auth()->id())
                ->where('status', 'paid')
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->sum('amount'),
            'pendingPayments' => Task::where('user_id', auth()->id())
                ->where('status', 'pending')
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->sum('amount'),
            'totalExpenses' => Expense::where('user_id', auth()->id())
                ->where('status', 'bought')
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->sum('amount'),
            'employerIncome' => Task::where('user_id', auth()->id())
                ->where('status', 'paid')
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->selectRaw('employer, SUM(amount) as total')
                ->groupBy('employer')
                ->get(),
            'budgetData' => Budget::where('user_id', auth()->id())
                ->where('month', $currentMonth)
                ->where('year', $currentYear)
                ->get()
        ];
        
        $data['balance'] = $data['totalIncome'] - $data['totalExpenses'];
        
        return response()->json($data);
    }

    /**
     * Get monthly trend data for analytics
     */
    private function getMonthlyTrend($userId, $months = 6)
    {
        $trendData = [];
        $currentDate = now();
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = $currentDate->copy()->subMonths($i);
            $year = $date->year;
            $month = $date->month;
            
            $monthlyIncome = Task::where('user_id', $userId)
                ->where('status', 'paid')
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->sum('amount');
                
            $monthlyExpenses = Budget::where('user_id', $userId)
                ->where('year', $year)
                ->where('month', $month)
                ->sum('actual_amount');
            
            $trendData[] = [
                'month' => $date->format('M Y'),
                'income' => $monthlyIncome,
                'expenses' => $monthlyExpenses,
                'balance' => $monthlyIncome - $monthlyExpenses
            ];
        }
        
        return $trendData;
    }
}
