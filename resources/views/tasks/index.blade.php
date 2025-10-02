<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OBADIA - Task Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .header h1 {
            color: #4a5568;
            font-size: 2rem;
            font-weight: 600;
        }

        .header h1 i {
            color: #667eea;
            margin-right: 10px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #4a5568;
        }

        .month-selector select {
            padding: 10px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout-btn {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        /* Navigation Tabs */
        .nav-tabs {
            display: flex;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 5px;
            margin-bottom: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .tab-btn {
            flex: 1;
            padding: 15px 20px;
            border: none;
            background: transparent;
            color: #718096;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .tab-btn:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        /* Main Content */
        .main-content {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        /* Section Header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .section-header h2 {
            color: #4a5568;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        /* Summary Cards */
        .summary-section {
            margin-bottom: 30px;
        }

        .overall-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-left: 4px solid;
            text-align: center;
        }

        .summary-card.total-income {
            border-left-color: #48bb78;
        }

        .summary-card.total-pending {
            border-left-color: #ed8936;
        }

        .summary-card.total-pages {
            border-left-color: #667eea;
        }

        .summary-card.total-tasks {
            border-left-color: #9f7aea;
        }

        .summary-card h3 {
            font-size: 0.9rem;
            color: #718096;
            margin-bottom: 10px;
        }

        .summary-card .amount {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d3748;
        }

        /* Employer Summary */
        .employer-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .employer-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .employer-card h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: #4a5568;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .employer-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2d3748;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #718096;
            margin-top: 5px;
        }

        /* Filters */
        .filter-section {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .filter-section select {
            padding: 10px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-section select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Tasks Table */
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-paid {
            background: #c6f6d5;
            color: #22543d;
        }

        .status-pending {
            background: #fed7aa;
            color: #9c4221;
        }

        /* Due/Aging badges */
        .due-badge {
            padding: 5px 10px;
            border-radius: 14px;
            font-size: 0.78rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }
        .due-overdue { background: #fed7d7; color: #9b2c2c; }
        .due-today { background: #fff3cd; color: #856404; }
        .due-tomorrow { background: #e6fffa; color: #234e52; }
        .due-future { background: #ebf8ff; color: #2b6cb0; }
        .due-none { background: #edf2f7; color: #4a5568; }

        /* Aging chips summary */
        .aging-summary { display:flex; flex-wrap:wrap; gap:10px; margin: 10px 0 20px 0; }
        .aging-chip { padding:8px 12px; border-radius:18px; font-size:0.8rem; font-weight:700; background:#f7fafc; color:#4a5568; border:1px solid #e2e8f0; }
        .aging-chip i { margin-right:6px; }

        .employer-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            color: white;
        }

        .employer-macflex {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .employer-researcher {
            background: linear-gradient(135deg, #48bb78, #38a169);
        }

        .employer-whatsapp-dc {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-edit {
            background: #4299e1;
            color: white;
        }

        .btn-delete {
            background: #f56565;
            color: white;
        }

        .btn-sm:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #718096;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #e2e8f0;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #4a5568;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .section-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .filter-section {
                flex-direction: column;
            }

            .overall-summary {
                grid-template-columns: repeat(2, 1fr);
            }

            .employer-summary {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 0.9rem;
            }

            th, td {
                padding: 10px 8px;
            }
        }

        /* Footer Styles */
        .dashboard-footer {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 20px;
            margin-top: 30px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #718096;
            font-size: 0.9rem;
        }

        .footer-links a {
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #764ba2;
        }

        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <h1><i class="fas fa-tasks"></i> OBADIA Task Management</h1>
            <div class="header-right">
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <div class="month-selector">
                    <select id="monthSelect" onchange="changeMonth()">
                        <option value="1" {{ $currentMonth == 1 ? 'selected' : '' }}>January</option>
                        <option value="2" {{ $currentMonth == 2 ? 'selected' : '' }}>February</option>
                        <option value="3" {{ $currentMonth == 3 ? 'selected' : '' }}>March</option>
                        <option value="4" {{ $currentMonth == 4 ? 'selected' : '' }}>April</option>
                        <option value="5" {{ $currentMonth == 5 ? 'selected' : '' }}>May</option>
                        <option value="6" {{ $currentMonth == 6 ? 'selected' : '' }}>June</option>
                        <option value="7" {{ $currentMonth == 7 ? 'selected' : '' }}>July</option>
                        <option value="8" {{ $currentMonth == 8 ? 'selected' : '' }}>August</option>
                        <option value="9" {{ $currentMonth == 9 ? 'selected' : '' }}>September</option>
                        <option value="10" {{ $currentMonth == 10 ? 'selected' : '' }}>October</option>
                        <option value="11" {{ $currentMonth == 11 ? 'selected' : '' }}>November</option>
                        <option value="12" {{ $currentMonth == 12 ? 'selected' : '' }}>December</option>
                    </select>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Navigation Tabs -->
        <nav class="nav-tabs">
            <a href="{{ route('dashboard') }}" class="tab-btn">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('tasks.index') }}" class="tab-btn active">
                <i class="fas fa-tasks"></i> Tasks
            </a>
            <a href="{{ route('budget.index') }}" class="tab-btn">
                <i class="fas fa-wallet"></i> Budget
            </a>
            <a href="{{ route('expenses.index') }}" class="tab-btn">
                <i class="fas fa-receipt"></i> Expenses
            </a>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- Section Header -->
            <div class="section-header">
                <h2>Task Management</h2>
                <div style="display:flex; gap:10px;">
                    <a href="{{ route('tasks.export', ['month' => $currentMonth, 'employer' => $employerFilter, 'status' => $statusFilter]) }}" class="btn-primary" style="background:linear-gradient(135deg,#38a169 0%,#2f855a 100%);">
                        <i class="fas fa-file-csv"></i> Export CSV
                    </a>
                    <a href="{{ route('tasks.create') }}" class="btn-primary">
                        <i class="fas fa-plus"></i> Add New Task
                    </a>
                </div>
            </div>

            <!-- Overall Summary -->
            <div class="summary-section">
                <h3 style="color: #4a5568; margin-bottom: 20px; font-size: 1.3rem;">
                    <i class="fas fa-chart-bar"></i> Overall Summary
                </h3>
                <div class="overall-summary">
                    <div class="summary-card total-income">
                        <h3><i class="fas fa-coins"></i> Total Income</h3>
                        <div class="amount">{{ number_format($totalIncome, 2) }} KSH</div>
                    </div>
                    <div class="summary-card total-pending">
                        <h3><i class="fas fa-clock"></i> Pending Payments</h3>
                        <div class="amount">{{ number_format($totalPending, 2) }} KSH</div>
                    </div>
                    <div class="summary-card total-pages">
                        <h3><i class="fas fa-file-alt"></i> Total Pages</h3>
                        <div class="amount">{{ number_format($totalPages) }}</div>
                    </div>
                    <div class="summary-card total-tasks">
                        <h3><i class="fas fa-list"></i> Total Tasks</h3>
                        <div class="amount">{{ number_format($totalTasks) }}</div>
                    </div>
                </div>
            </div>

            <!-- Employer Summary -->
            <div class="summary-section">
                <h3 style="color: #4a5568; margin-bottom: 20px; font-size: 1.3rem;">
                    <i class="fas fa-building"></i> Employer Summary
                </h3>
                <div class="employer-summary">
                    @php
                        $macflex = $employerSummaries['MACFLEX'] ?? [
                            'total_income' => 0,
                            'pending_amount' => 0,
                            'total_pages' => 0,
                            'task_count' => 0,
                        ];
                        $researcher = $employerSummaries['RESEARCHER'] ?? [
                            'total_income' => 0,
                            'pending_amount' => 0,
                            'total_pages' => 0,
                            'task_count' => 0,
                        ];
                        $whatsapp = $employerSummaries['WHATSAPP DC'] ?? [
                            'total_income' => 0,
                            'pending_amount' => 0,
                            'total_pages' => 0,
                            'task_count' => 0,
                        ];
                    @endphp
                    <div class="employer-card">
                        <h3>
                            <span class="employer-badge employer-macflex">MACFLEX</span>
                        </h3>
                        <div class="employer-stats">
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($macflex['total_income'], 2) }} KSH</div>
                                <div class="stat-label">Paid Income</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($macflex['pending_amount'], 2) }} KSH</div>
                                <div class="stat-label">Pending</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($macflex['total_pages']) }}</div>
                                <div class="stat-label">Pages</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($macflex['task_count']) }}</div>
                                <div class="stat-label">Tasks</div>
                            </div>
                        </div>
                    </div>

                    <div class="employer-card">
                        <h3>
                            <span class="employer-badge employer-researcher">RESEARCHER</span>
                        </h3>
                        <div class="employer-stats">
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($researcher['total_income'], 2) }} KSH</div>
                                <div class="stat-label">Paid Income</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($researcher['pending_amount'], 2) }} KSH</div>
                                <div class="stat-label">Pending</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($researcher['total_pages']) }}</div>
                                <div class="stat-label">Pages</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($researcher['task_count']) }}</div>
                                <div class="stat-label">Tasks</div>
                            </div>
                        </div>
                    </div>

                    <div class="employer-card">
                        <h3>
                            <span class="employer-badge employer-whatsapp-dc">WHATSAPP DC</span>
                        </h3>
                        <div class="employer-stats">
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($whatsapp['total_income'], 2) }} KSH</div>
                                <div class="stat-label">Paid Income</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($whatsapp['pending_amount'], 2) }} KSH</div>
                                <div class="stat-label">Pending</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($whatsapp['total_pages']) }}</div>
                                <div class="stat-label">Pages</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ number_format($whatsapp['task_count']) }}</div>
                                <div class="stat-label">Tasks</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filter-section">
                <select id="employerFilter" onchange="applyFilters()">
                    <option value="">All Employers</option>
                    <option value="MACFLEX" {{ $employerFilter == 'MACFLEX' ? 'selected' : '' }}>MACFLEX</option>
                    <option value="RESEARCHER" {{ $employerFilter == 'RESEARCHER' ? 'selected' : '' }}>RESEARCHER</option>
                    <option value="WHATSAPP DC" {{ $employerFilter == 'WHATSAPP DC' ? 'selected' : '' }}>WHATSAPP DC</option>
                </select>
                <select id="statusFilter" onchange="applyFilters()">
                    <option value="">All Status</option>
                    <option value="pending" {{ $statusFilter == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $statusFilter == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>

            <!-- Aging Buckets Summary -->
            @php
                $now = \Carbon\Carbon::now();
                $dueToday = $tasks->filter(function($t) use ($now) {
                    return $t->status === 'pending' && $t->deadline && $t->deadline->isSameDay($now);
                })->count();
                $dueTomorrow = $tasks->filter(function($t) use ($now) {
                    return $t->status === 'pending' && $t->deadline && $t->deadline->isSameDay($now->copy()->addDay());
                })->count();
                $overdue = $tasks->filter(function($t) use ($now) {
                    return $t->status === 'pending' && $t->deadline && $t->deadline->lt($now);
                })->count();
                $future = $tasks->filter(function($t) use ($now) {
                    return $t->status === 'pending' && $t->deadline && $t->deadline->gt($now->copy()->addDay());
                })->count();
            @endphp
            <div class="aging-summary">
                <span class="aging-chip"><i class="fas fa-exclamation-triangle" style="color:#e53e3e;"></i> Overdue: {{ $overdue }}</span>
                <span class="aging-chip"><i class="fas fa-sun" style="color:#dd6b20;"></i> Due Today: {{ $dueToday }}</span>
                <span class="aging-chip"><i class="fas fa-moon" style="color:#38a169;"></i> Due Tomorrow: {{ $dueTomorrow }}</span>
                <span class="aging-chip"><i class="fas fa-calendar-alt" style="color:#3182ce;"></i> Future: {{ $future }}</span>
            </div>

            <!-- Tasks Table -->
            @if($tasks->count() > 0)
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Employer</th>
                                <th>Task Description</th>
                                <th>Pages</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Due</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                                <tr>
                                    <td>{{ $task->date->format('M d, Y') }}</td>
                                    <td>
                                        @php
                                            $empClass = \Illuminate\Support\Str::slug(strtolower($task->employer));
                                        @endphp
                                        <span class="employer-badge employer-{{ $empClass }}">
                                            {{ $task->employer }}
                                        </span>
                                    </td>
                                    <td>{{ $task->task_description }}</td>
                                    <td>{{ number_format($task->pages) }}</td>
                                    <td>{{ number_format($task->rate, 2) }} KSH</td>
                                    <td><strong>{{ number_format($task->amount, 2) }} KSH</strong></td>
                                    <td>
                                        <span class="status-badge status-{{ $task->status }}">
                                            {{ ucfirst($task->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeText = 'No deadline';
                                            $badgeClass = 'due-none';
                                            if ($task->deadline) {
                                                $diffInMinutes = \Carbon\Carbon::now()->diffInMinutes($task->deadline, false);
                                                if ($diffInMinutes < 0) {
                                                    $daysOver = (int) ceil(abs($diffInMinutes) / 60 / 24);
                                                    $badgeText = 'Overdue ' . $daysOver . 'd';
                                                    $badgeClass = 'due-overdue';
                                                } else {
                                                    $days = (int) floor($diffInMinutes / 60 / 24);
                                                    $hours = (int) floor(($diffInMinutes - ($days*24*60)) / 60);
                                                    if ($days === 0) {
                                                        $badgeText = 'Due today ~' . $hours . 'h';
                                                        $badgeClass = 'due-today';
                                                    } elseif ($days === 1) {
                                                        $badgeText = 'Due tomorrow';
                                                        $badgeClass = 'due-tomorrow';
                                                    } else {
                                                        $badgeText = 'In ' . $days . 'd';
                                                        $badgeClass = 'due-future';
                                                    }
                                                }
                                            }
                                        @endphp
                                        @php if (!isset($badgeClass) || !isset($badgeText)) { $badgeClass = 'due-none'; $badgeText = 'No deadline'; } @endphp
                                    <span class="due-badge {{ $badgeClass }}">
                                            <i class="fas {{ $badgeClass === 'due-overdue' ? 'fa-exclamation-circle' : ($badgeClass === 'due-today' ? 'fa-sun' : ($badgeClass === 'due-tomorrow' ? 'fa-moon' : ($badgeClass === 'due-future' ? 'fa-calendar-alt' : 'fa-clock'))) }}"></i>
                                            {{ $badgeText }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn-sm btn-edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Are you sure you want to delete this task?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-sm btn-delete">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-tasks"></i>
                    <h3>No Tasks Found</h3>
                    <p>Start by adding your first task from one of your employers!</p>
                    <a href="{{ route('tasks.create') }}" class="btn-primary" style="margin-top: 20px;">
                        <i class="fas fa-plus"></i> Add Your First Task
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Footer -->
        <footer class="dashboard-footer">
            <div class="footer-content">
                <p>&copy; 2025 OBADIAH | All Rights Reserved</p>
                <div class="footer-links">
                    <a href="#">Help</a> | 
                    <a href="#">Support</a> | 
                    <a href="#">Version 1.0</a>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Month selector functionality
        function changeMonth() {
            const month = document.getElementById('monthSelect').value;
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('month', month);
            window.location.href = currentUrl.toString();
        }

        // Filter functionality
        function applyFilters() {
            const employer = document.getElementById('employerFilter').value;
            const status = document.getElementById('statusFilter').value;
            const month = document.getElementById('monthSelect').value;
            
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('month', month);
            
            if (employer) {
                currentUrl.searchParams.set('employer', employer);
            } else {
                currentUrl.searchParams.delete('employer');
            }
            
            if (status) {
                currentUrl.searchParams.set('status', status);
            } else {
                currentUrl.searchParams.delete('status');
            }
            
            window.location.href = currentUrl.toString();
        }
    </script>
</body>
</html>
