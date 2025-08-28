<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    // List all tasks with filtering
    public function index(Request $request)
    {
        $currentMonth = $request->get('month', now()->month);
        $currentYear = now()->year;
        $employerFilter = $request->get('employer');
        $statusFilter = $request->get('status');
        
        $monthStart = Carbon::create($currentYear, $currentMonth, 1)->startOfMonth();
        $monthEnd = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();
        
        // Build query
        $query = Task::where('user_id', auth()->id())
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->orderBy('date', 'desc');
            
        // Apply filters
        if ($employerFilter) {
            $query->where('employer', $employerFilter);
        }
        
        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }
        
        $tasks = $query->get();
        
        // Calculate summaries by employer
        $employerSummaries = [
            'MACFLEX' => [
                'total_income' => 0,
                'pending_amount' => 0,
                'total_pages' => 0,
                'task_count' => 0
            ],
            'JUJA' => [
                'total_income' => 0,
                'pending_amount' => 0,
                'total_pages' => 0,
                'task_count' => 0
            ],
            'MERU' => [
                'total_income' => 0,
                'pending_amount' => 0,
                'total_pages' => 0,
                'task_count' => 0
            ]
        ];
        
        // Calculate summaries
        foreach ($tasks as $task) {
            if (isset($employerSummaries[$task->employer])) {
                $employerSummaries[$task->employer]['task_count']++;
                $employerSummaries[$task->employer]['total_pages'] += $task->pages;
                
                if ($task->status === 'paid') {
                    $employerSummaries[$task->employer]['total_income'] += $task->amount;
                } else {
                    $employerSummaries[$task->employer]['pending_amount'] += $task->amount;
                }
            }
        }
        
        // Calculate overall totals
        $totalIncome = array_sum(array_column($employerSummaries, 'total_income'));
        $totalPending = array_sum(array_column($employerSummaries, 'pending_amount'));
        $totalPages = array_sum(array_column($employerSummaries, 'total_pages'));
        $totalTasks = array_sum(array_column($employerSummaries, 'task_count'));
        
        return view('tasks.index', compact(
            'tasks',
            'employerSummaries',
            'totalIncome',
            'totalPending',
            'totalPages',
            'totalTasks',
            'currentMonth',
            'employerFilter',
            'statusFilter'
        ));
    }
    
    // Show create task form
    public function create()
    {
        $employers = auth()->user()->employers()->active()->orderBy('name')->get();
        return view('tasks.create', compact('employers'));
    }
    
    // Store new task
    public function store(Request $request)
    {
        // Get user's active employers for validation
        $userEmployers = auth()->user()->employers()->active()->pluck('id')->toArray();
        $fallbackEmployers = ['juja', 'macflex', 'meru'];
        $validEmployers = array_merge($userEmployers, $fallbackEmployers);
        
        // Custom validation for employer_id (can be existing ID, fallback name, or new employer)
        $validator = Validator::make($request->all(), [
            'employer_id' => [
                'required',
                function ($attribute, $value, $fail) use ($validEmployers) {
                    // Allow existing employers, fallback employers, or new employers (prefixed with 'new:')
                    if (!in_array($value, $validEmployers) && !str_starts_with($value, 'new:')) {
                        $fail('The selected employer is invalid.');
                    }
                    // If it's a new employer, validate the name
                    if (str_starts_with($value, 'new:')) {
                        $newEmployerName = substr($value, 4); // Remove 'new:' prefix
                        if (empty(trim($newEmployerName)) || strlen($newEmployerName) > 100) {
                            $fail('The new employer name must be between 1 and 100 characters.');
                        }
                    }
                }
            ],
            'task_description' => 'required|string|max:500',
            'pages' => 'required|integer|min:1|max:1000',
            'rate' => 'required|numeric|min:0|max:1000',
            'status' => 'required|in:pending,paid',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Handle employer name and ID
        $employerName = '';
        $employerId = null;
        
        if (str_starts_with($request->employer_id, 'new:')) {
            // Handle new employer names
            $employerName = trim(substr($request->employer_id, 4)); // Remove 'new:' prefix
            // Don't set employerId - leave as null for new employers
            
        } elseif (in_array($request->employer_id, $fallbackEmployers)) {
            // Handle fallback employers (juja, macflex, meru)
            $employerName = strtoupper($request->employer_id);
            
            // Try to find or create the employer in database
            $employer = auth()->user()->employers()->where('name', $employerName)->first();
            if ($employer) {
                $employerId = $employer->id;
            }
        } else {
            // Handle database employers
            $employer = auth()->user()->employers()->find($request->employer_id);
            if ($employer) {
                $employerName = $employer->name;
                $employerId = $employer->id;
            }
        }
        
        // Ensure we have an employer name
        if (empty($employerName)) {
            return redirect()->back()
                ->withErrors(['employer_id' => 'Employer name could not be determined.'])
                ->withInput();
        }
        
        // Calculate amount
        $amount = $request->pages * $request->rate;
        
        Task::create([
            'user_id' => auth()->id(),
            'employer' => $employerName,
            'employer_id' => $employerId,
            'task_description' => $request->task_description,
            'pages' => $request->pages,
            'rate' => $request->rate,
            'amount' => $amount,
            'status' => $request->status,
            'date' => $request->date,
            'notes' => $request->notes
        ]);
        
        return redirect()->route('tasks.index')
            ->with('success', 'Task added successfully for ' . $employerName . '!');
    }
    
    // Show edit task form
    public function edit(Task $task)
    {
        // Ensure user can only edit their own tasks
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('tasks.edit', compact('task'));
    }
    
    // Update task
    public function update(Request $request, Task $task)
    {
        // Ensure user can only update their own tasks
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
        
        $validator = Validator::make($request->all(), [
            'employer' => 'required|in:MACFLEX,JUJA,MERU',
            'task_description' => 'required|string|max:500',
            'pages' => 'required|integer|min:1|max:1000',
            'rate' => 'required|numeric|min:0|max:1000',
            'status' => 'required|in:pending,paid',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:1000'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Calculate amount
        $amount = $request->pages * $request->rate;
        
        $task->update([
            'employer' => $request->employer,
            'task_description' => $request->task_description,
            'pages' => $request->pages,
            'rate' => $request->rate,
            'amount' => $amount,
            'status' => $request->status,
            'date' => $request->date,
            'notes' => $request->notes
        ]);
        
        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }
    
    // Delete task
    public function destroy(Task $task)
    {
        // Ensure user can only delete their own tasks
        if ($task->user_id !== auth()->id()) {
            abort(403);
        }
        
        $employer = $task->employer;
        $task->delete();
        
        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully from ' . $employer . '!');
    }
    
    // API endpoint for AJAX data
    public function getTasksData(Request $request)
    {
        $currentMonth = $request->get('month', now()->month);
        $currentYear = now()->year;
        
        $monthStart = Carbon::create($currentYear, $currentMonth, 1)->startOfMonth();
        $monthEnd = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();
        
        $tasks = Task::where('user_id', auth()->id())
            ->whereBetween('date', [$monthStart, $monthEnd])
            ->get();
            
        $employerData = [
            'MACFLEX' => ['paid' => 0, 'pending' => 0],
            'JUJA' => ['paid' => 0, 'pending' => 0],
            'MERU' => ['paid' => 0, 'pending' => 0]
        ];
        
        foreach ($tasks as $task) {
            if (isset($employerData[$task->employer])) {
                $employerData[$task->employer][$task->status] += $task->amount;
            }
        }
        
        return response()->json($employerData);
    }
}
