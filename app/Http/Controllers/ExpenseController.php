<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the expenses.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $currentMonth = $request->get('month', now()->format('Y-m'));
        $monthParts = explode('-', $currentMonth);
        $year = $monthParts[0];
        $month = $monthParts[1];

        // Get expenses for the selected month
        $expenses = Expense::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();

        // Expense categories
        $categories = ['Bills', 'Wants', 'Savings', 'Debts'];

        // Calculate totals
        $totalExpenses = Expense::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('amount');

        $necessaryExpenses = Expense::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->where('necessary', true)
            ->sum('amount');

        $unnecessaryExpenses = $totalExpenses - $necessaryExpenses;

        // Get category summaries
        $categorySummaries = [];
        foreach ($categories as $category) {
            $categoryExpenses = $expenses->get($category, collect());
            $categorySummaries[$category] = [
                'total' => $categoryExpenses->sum('amount'),
                'necessary' => $categoryExpenses->where('necessary', true)->sum('amount'),
                'unnecessary' => $categoryExpenses->where('necessary', false)->sum('amount'),
                'count' => $categoryExpenses->count()
            ];
        }

        return view('expenses.index', compact(
            'expenses',
            'categories',
            'categorySummaries',
            'totalExpenses',
            'necessaryExpenses',
            'unnecessaryExpenses',
            'currentMonth'
        ));
    }

    /**
     * Show the form for creating a new expense.
     */
    public function create()
    {
        $categories = ['Bills', 'Wants', 'Savings', 'Debts'];
        return view('expenses.create', compact('categories'));
    }

    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0|max:999999.99',
            'category' => 'required|in:Bills,Wants,Savings,Debts',
            'necessary' => 'required|boolean',
            'status' => 'required|in:paid,pending',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:1000'
        ]);

        Expense::create([
            'user_id' => Auth::id(),
            'item' => $request->item,
            'amount' => $request->amount,
            'category' => $request->category,
            'necessary' => $request->necessary,
            'status' => $request->status,
            'date' => $request->date,
            'notes' => $request->notes
        ]);

        return redirect()->route('expenses.index', ['month' => date('Y-m', strtotime($request->date))])
            ->with('success', 'Expense created successfully!');
    }

    /**
     * Show the form for editing the specified expense.
     */
    public function edit(Expense $expense)
    {
        // Ensure user can only edit their own expenses
        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = ['Bills', 'Wants', 'Savings', 'Debts'];
        return view('expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified expense in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        // Ensure user can only update their own expenses
        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'item' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0|max:999999.99',
            'category' => 'required|in:Bills,Wants,Savings,Debts',
            'necessary' => 'required|boolean',
            'status' => 'required|in:paid,pending',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:1000'
        ]);

        $expense->update([
            'item' => $request->item,
            'amount' => $request->amount,
            'category' => $request->category,
            'necessary' => $request->necessary,
            'status' => $request->status,
            'date' => $request->date,
            'notes' => $request->notes
        ]);

        return redirect()->route('expenses.index', ['month' => date('Y-m', strtotime($request->date))])
            ->with('success', 'Expense updated successfully!');
    }

    /**
     * Remove the specified expense from storage.
     */
    public function destroy(Expense $expense)
    {
        // Ensure user can only delete their own expenses
        if ($expense->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $month = date('Y-m', strtotime($expense->date));
        $expense->delete();

        return redirect()->route('expenses.index', ['month' => $month])
            ->with('success', 'Expense deleted successfully!');
    }

    /**
     * Get expense data for AJAX requests.
     */
    public function getExpenseData(Request $request)
    {
        $user = Auth::user();
        $currentMonth = $request->get('month', now()->format('Y-m'));
        $monthParts = explode('-', $currentMonth);
        $year = $monthParts[0];
        $month = $monthParts[1];

        // Get expenses for the selected month
        $expenses = Expense::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();

        // Expense categories
        $categories = ['Bills', 'Wants', 'Savings', 'Debts'];

        // Calculate totals
        $totalExpenses = Expense::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->sum('amount');

        $necessaryExpenses = Expense::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->where('necessary', true)
            ->sum('amount');

        // Get category summaries
        $categorySummaries = [];
        foreach ($categories as $category) {
            $categoryExpenses = $expenses->get($category, collect());
            $categorySummaries[$category] = [
                'total' => $categoryExpenses->sum('amount'),
                'necessary' => $categoryExpenses->where('necessary', true)->sum('amount'),
                'unnecessary' => $categoryExpenses->where('necessary', false)->sum('amount'),
                'count' => $categoryExpenses->count()
            ];
        }

        return response()->json([
            'expenses' => $expenses,
            'categorySummaries' => $categorySummaries,
            'totalExpenses' => $totalExpenses,
            'necessaryExpenses' => $necessaryExpenses,
            'unnecessaryExpenses' => $totalExpenses - $necessaryExpenses,
            'currentMonth' => $currentMonth
        ]);
    }
}
