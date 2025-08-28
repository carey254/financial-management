<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserSettingsController;

// Landing page with authentication
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.landing');
})->name('landing');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/auth/check', [LoginController::class, 'checkAuth'])->name('auth.check');

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Tasks
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    
    // Budget
    Route::get('/budget', [BudgetController::class, 'index'])->name('budget.index');
    Route::get('/budget/create', [BudgetController::class, 'create'])->name('budget.create');
    Route::post('/budget', [BudgetController::class, 'store'])->name('budget.store');
    Route::get('/budget/{budget}/edit', [BudgetController::class, 'edit'])->name('budget.edit');
    Route::put('/budget/{budget}', [BudgetController::class, 'update'])->name('budget.update');
    Route::delete('/budget/{budget}', [BudgetController::class, 'destroy'])->name('budget.destroy');
    
    // Expenses
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
    Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    
    // User Settings
    Route::get('/settings', [UserSettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/profile', [UserSettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::put('/settings/password', [UserSettingsController::class, 'updatePassword'])->name('settings.password.update');
    Route::put('/settings/preferences', [UserSettingsController::class, 'updatePreferences'])->name('settings.preferences.update');
    Route::post('/settings/employers', [UserSettingsController::class, 'storeEmployer'])->name('settings.employers.store');
    Route::put('/settings/employers/{employer}', [UserSettingsController::class, 'updateEmployer'])->name('settings.employers.update');
    Route::delete('/settings/employers/{employer}', [UserSettingsController::class, 'destroyEmployer'])->name('settings.employers.destroy');
    
    // Debug route to check data persistence
    Route::get('/debug/data', [\App\Http\Controllers\DebugController::class, 'checkData'])->name('debug.data');
    
    // API routes for AJAX requests
    Route::get('/api/dashboard-data', [DashboardController::class, 'getDashboardData'])->name('api.dashboard');
    Route::get('/api/tasks-data', [TaskController::class, 'getTasksData'])->name('api.tasks');
});
