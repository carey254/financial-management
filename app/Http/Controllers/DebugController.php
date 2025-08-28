<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Task;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebugController extends Controller
{
    /**
     * Debug data persistence issues
     */
    public function checkData(Request $request)
    {
        $user = Auth::user();
        
        // Get all user data regardless of filters
        $allBudgets = Budget::where('user_id', $user->id)->get();
        $allTasks = Task::where('user_id', $user->id)->get();
        $allExpenses = Expense::where('user_id', $user->id)->get();
        
        // Current month data
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $currentBudgets = Budget::where('user_id', $user->id)
            ->where('year', $currentYear)
            ->where('month', $currentMonth)
            ->get();
            
        return response()->json([
            'user_id' => $user->id,
            'current_month' => $currentMonth,
            'current_year' => $currentYear,
            'total_budgets' => $allBudgets->count(),
            'current_month_budgets' => $currentBudgets->count(),
            'total_tasks' => $allTasks->count(),
            'total_expenses' => $allExpenses->count(),
            'all_budgets' => $allBudgets->toArray(),
            'current_budgets' => $currentBudgets->toArray(),
            'budget_months' => $allBudgets->pluck('month', 'year')->unique(),
        ]);
    }
}
