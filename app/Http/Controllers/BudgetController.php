<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BudgetController extends Controller
{
    /**
     * Display a listing of the budgets.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $currentMonth = $request->get('month', now()->format('Y-m'));
        $monthParts = explode('-', $currentMonth);
        $year = (int) $monthParts[0];
        $month = (int) $monthParts[1];
        
        // Debug: Log what we're searching for
        \Log::info('Budget search params', ['user_id' => $user->id, 'year' => $year, 'month' => $month]);

        // Get budgets for the selected month
        $budgets = Budget::where('user_id', $user->id)
            ->where('year', $year)
            ->where('month', $month)
            ->get()
            ->groupBy('category');

        // Budget categories
        $categories = ['Bills', 'Wants', 'Savings', 'Debts'];

        // Calculate totals
        $totalBudgeted = Budget::where('user_id', $user->id)
            ->where('year', $year)
            ->where('month', $month)
            ->sum('budgeted_amount');

        $totalActual = Budget::where('user_id', $user->id)
            ->where('year', $year)
            ->where('month', $month)
            ->sum('actual_amount');

        $totalDifference = $totalBudgeted - $totalActual;

        // Get category summaries
        $categorySummaries = [];
        foreach ($categories as $category) {
            $categoryBudgets = $budgets->get($category, collect());
            $categorySummaries[$category] = [
                'budgeted' => $categoryBudgets->sum('budgeted_amount'),
                'actual' => $categoryBudgets->sum('actual_amount'),
                'difference' => $categoryBudgets->sum('budgeted_amount') - $categoryBudgets->sum('actual_amount'),
                'count' => $categoryBudgets->count()
            ];
        }

        return view('budget.index', compact(
            'budgets',
            'categories',
            'categorySummaries',
            'totalBudgeted',
            'totalActual',
            'totalDifference',
            'currentMonth'
        ));
    }

    /**
     * Show the form for creating a new budget.
     */
    public function create()
    {
        $categories = ['Bills', 'Wants', 'Savings', 'Debts'];
        return view('budget.create', compact('categories'));
    }

    /**
     * Store a newly created budget in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|in:Bills,Wants,Savings,Debts',
            'item' => 'required|string|max:255',
            'budgeted_amount' => 'required|numeric|min:0|max:999999.99',
            'actual_amount' => 'nullable|numeric|min:0|max:999999.99',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|between:2020,2030',
            'notes' => 'nullable|string|max:1000'
        ]);

        Budget::create([
            'user_id' => Auth::id(),
            'category' => $request->category,
            'item' => $request->item,
            'budgeted_amount' => $request->budgeted_amount,
            'actual_amount' => $request->actual_amount ?? 0,
            'month' => $request->month,
            'year' => $request->year,
            'notes' => $request->notes
        ]);

        return redirect()->route('budget.index', ['month' => $request->year . '-' . str_pad($request->month, 2, '0', STR_PAD_LEFT)])
            ->with('success', 'Budget item created successfully!');
    }

    /**
     * Show the form for editing the specified budget.
     */
    public function edit(Budget $budget)
    {
        // Ensure user can only edit their own budgets
        if ($budget->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = ['Bills', 'Wants', 'Savings', 'Debts'];
        return view('budget.edit', compact('budget', 'categories'));
    }

    /**
     * Update the specified budget in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        // Ensure user can only update their own budgets
        if ($budget->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'category' => 'required|in:Bills,Wants,Savings,Debts',
            'item' => 'required|string|max:255',
            'budgeted_amount' => 'required|numeric|min:0|max:999999.99',
            'actual_amount' => 'nullable|numeric|min:0|max:999999.99',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|between:2020,2030',
            'notes' => 'nullable|string|max:1000'
        ]);

        $budget->update([
            'category' => $request->category,
            'item' => $request->item,
            'budgeted_amount' => $request->budgeted_amount,
            'actual_amount' => $request->actual_amount ?? 0,
            'month' => $request->month,
            'year' => $request->year,
            'notes' => $request->notes
        ]);

        return redirect()->route('budget.index', ['month' => $request->year . '-' . str_pad($request->month, 2, '0', STR_PAD_LEFT)])
            ->with('success', 'Budget item updated successfully!');
    }

    /**
     * Remove the specified budget from storage.
     */
    public function destroy(Budget $budget)
    {
        // Ensure user can only delete their own budgets
        if ($budget->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $month = $budget->year . '-' . str_pad($budget->month, 2, '0', STR_PAD_LEFT);
        $budget->delete();

        return redirect()->route('budget.index', ['month' => $month])
            ->with('success', 'Budget item deleted successfully!');
    }

    /**
     * Get budget data for AJAX requests.
     */
    public function getBudgetData(Request $request)
    {
        $user = Auth::user();
        $currentMonth = $request->get('month', now()->format('Y-m'));
        $monthParts = explode('-', $currentMonth);
        $year = $monthParts[0];
        $month = $monthParts[1];

        // Get budgets for the selected month
        $budgets = Budget::where('user_id', $user->id)
            ->where('year', $year)
            ->where('month', $month)
            ->get()
            ->groupBy('category');

        // Budget categories
        $categories = ['Bills', 'Wants', 'Savings', 'Debts'];

        // Calculate totals
        $totalBudgeted = Budget::where('user_id', $user->id)
            ->where('year', $year)
            ->where('month', $month)
            ->sum('budgeted_amount');

        $totalActual = Budget::where('user_id', $user->id)
            ->where('year', $year)
            ->where('month', $month)
            ->sum('actual_amount');

        // Get category summaries
        $categorySummaries = [];
        foreach ($categories as $category) {
            $categoryBudgets = $budgets->get($category, collect());
            $categorySummaries[$category] = [
                'budgeted' => $categoryBudgets->sum('budgeted_amount'),
                'actual' => $categoryBudgets->sum('actual_amount'),
                'difference' => $categoryBudgets->sum('budgeted_amount') - $categoryBudgets->sum('actual_amount'),
                'count' => $categoryBudgets->count()
            ];
        }

        return response()->json([
            'budgets' => $budgets,
            'categorySummaries' => $categorySummaries,
            'totalBudgeted' => $totalBudgeted,
            'totalActual' => $totalActual,
            'totalDifference' => $totalBudgeted - $totalActual,
            'currentMonth' => $currentMonth
        ]);
    }
}
