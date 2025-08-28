<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER Dashboard - Freelance Manager</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#764ba2">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="USER">
    <meta name="msapplication-TileColor" content="#667eea">
    <meta name="msapplication-config" content="/browserconfig.xml">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    
    <!-- PWA Icons -->
    <link rel="icon" type="image/png" sizes="32x32" href="/images/icons/icon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/icons/icon-72x72.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/icons/icon-192x192.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/icons/icon-144x144.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/icons/icon-128x128.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/images/icons/icon-128x128.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/images/icons/icon-72x72.png">
    <link rel="apple-touch-icon" href="/images/icons/icon-192x192.png">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .month-selector select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
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

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(245, 101, 101, 0.3);
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

        /* Summary Cards */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-left: 4px solid;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .income-card {
            border-left-color: #48bb78;
        }

        .expense-card {
            border-left-color: #f56565;
        }

        .balance-card {
            border-left-color: #667eea;
        }

        .pending-card {
            border-left-color: #ed8936;
        }

        .card h3 {
            font-size: 0.9rem;
            color: #718096;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card .amount {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
        }

        /* Charts Section */
        .charts-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
            max-height: 400px;
        }

        .chart-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            height: 350px;
            overflow: hidden;
        }

        .chart-card canvas {
            max-height: 280px !important;
            height: 280px !important;
        }

        .chart-card h3 {
            color: #4a5568;
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        /* Recent Activities */
        .recent-activities {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .recent-activities h3 {
            color: #4a5568;
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-size: 0.9rem;
        }

        .activity-icon.task {
            background: linear-gradient(135deg, #48bb78, #38a169);
        }

        .activity-icon.payment {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .activity-icon.expense {
            background: linear-gradient(135deg, #f56565, #e53e3e);
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 5px;
        }

        .activity-meta {
            font-size: 0.9rem;
            color: #718096;
        }

        .activity-amount {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .activity-amount.positive {
            color: #48bb78;
        }

        .activity-amount.negative {
            color: #f56565;
        }

        .activity-amount.pending {
            color: #ed8936;
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .quick-action-btn {
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

        .quick-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
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

            .header-right {
                flex-direction: column;
                gap: 10px;
            }

            .nav-tabs {
                flex-direction: column;
                gap: 5px;
            }

            .summary-cards {
                grid-template-columns: 1fr;
            }

            .charts-section {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                flex-direction: column;
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
            <h1><i class="fas fa-briefcase"></i> OBADIA Dashboard</h1>
            <div class="header-right">
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <span>Welcome, {{ auth()->user()->name }}!</span>
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
            <a href="{{ route('dashboard') }}" class="tab-btn active">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('tasks.index') }}" class="tab-btn">
                <i class="fas fa-tasks"></i> Tasks
            </a>
            <a href="{{ route('budget.index') }}" class="tab-btn">
                <i class="fas fa-wallet"></i> Budget
            </a>
            <a href="{{ route('expenses.index') }}" class="tab-btn" id="expenses-tab" style="pointer-events: auto; cursor: pointer;">
                <i class="fas fa-receipt"></i> Expenses
            </a>
            <a href="{{ route('settings.index') }}" class="tab-btn">
                <i class="fas fa-cog"></i> Settings
            </a>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="{{ route('tasks.create') }}" class="quick-action-btn">
                    <i class="fas fa-plus"></i> Add Task
                </a>
                <a href="{{ route('budget.create') }}" class="quick-action-btn">
                    <i class="fas fa-chart-pie"></i> Quick Budget
                </a>
                <a href="{{ route('expenses.create') }}" class="quick-action-btn">
                    <i class="fas fa-shopping-cart"></i> Add Expense
                </a>
            </div>

            <!-- Summary Cards -->
            <div class="summary-cards">
                <div class="card income-card">
                    <h3><i class="fas fa-arrow-up"></i> Total Income</h3>
                    <div class="amount">{{ number_format($totalIncome, 2) }} KSH</div>
                </div>
                <div class="card expense-card">
                    <h3><i class="fas fa-arrow-down"></i> Total Expenses</h3>
                    <div class="amount">{{ number_format($totalActualSpent, 2) }} KSH</div>
                </div>
                <div class="card balance-card">
                    <h3><i class="fas fa-balance-scale"></i> Balance</h3>
                    <div class="amount {{ $balance >= 0 ? 'positive' : 'negative' }}">{{ number_format($balance, 2) }} KSH</div>
                </div>
                <div class="card pending-card">
                    <h3><i class="fas fa-clock"></i> Pending Payments</h3>
                    <div class="amount">{{ number_format($pendingPayments, 2) }} KSH</div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-section">
                <div class="chart-card">
                    <h3>Budget vs Actual</h3>
                    <canvas id="budgetChart" width="400" height="200"></canvas>
                </div>
                <div class="chart-card">
                    <h3>Income by Employer</h3>
                    <canvas id="employerChart" width="400" height="200"></canvas>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="recent-activities">
                <h3><i class="fas fa-history"></i> Recent Activities</h3>
                @forelse($recentTasks as $task)
                    <div class="activity-item">
                        <div class="activity-icon task">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $task->task_description }}</div>
                            <div class="activity-meta">
                                {{ $task->employer }} • {{ $task->pages }} pages • {{ $task->date->format('M d, Y') }}
                            </div>
                        </div>
                        <div class="activity-amount {{ $task->status === 'paid' ? 'positive' : 'pending' }}">
                            {{ number_format($task->amount, 2) }} KSH
                            @if($task->status === 'pending')
                                <small>(Pending)</small>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="activity-item">
                        <div class="activity-icon task">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">No recent tasks</div>
                            <div class="activity-meta">Start by adding your first task!</div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Footer -->
        <footer class="dashboard-footer">
            <div class="footer-content">
                <p>&copy; 2025 User | All Rights Reserved</p>
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
            window.location.href = `{{ route('dashboard') }}?month=${month}`;
        }

        // Budget vs Actual Chart
        const budgetCtx = document.getElementById('budgetChart').getContext('2d');
        const budgetData = {
            labels: [
                @foreach($budgets as $budget)
                    '{{ $budget->category }}',
                @endforeach
            ],
            datasets: [{
                label: 'Budget',
                data: [
                    @foreach($budgets as $budget)
                        {{ $budget->budget_amount }},
                    @endforeach
                ],
                backgroundColor: 'rgba(102, 126, 234, 0.6)',
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 2
            }, {
                label: 'Actual',
                data: [
                    @foreach($budgets as $budget)
                        {{ $budget->actual_amount }},
                    @endforeach
                ],
                backgroundColor: 'rgba(245, 101, 101, 0.6)',
                borderColor: 'rgba(245, 101, 101, 1)',
                borderWidth: 2
            }]
        };

        new Chart(budgetCtx, {
            type: 'bar',
            data: budgetData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // Employer Income Chart
        const employerCtx = document.getElementById('employerChart').getContext('2d');
        const employerData = {
            labels: [
                @foreach($employerIncome as $income)
                    '{{ $income->employer }}',
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($employerIncome as $income)
                        {{ $income->total }},
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(118, 75, 162, 0.8)',
                    'rgba(72, 187, 120, 0.8)',
                    'rgba(237, 137, 54, 0.8)',
                    'rgba(245, 101, 101, 0.8)'
                ],
                borderWidth: 0
            }]
        };

        new Chart(employerCtx, {
            type: 'doughnut',
            data: employerData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Auto-refresh data every 30 seconds
        setInterval(function() {
            // You can implement AJAX refresh here if needed
        }, 30000);

        // Ensure expenses link is clickable
        document.addEventListener('DOMContentLoaded', function() {
            const expensesTab = document.getElementById('expenses-tab');
            if (expensesTab) {
                expensesTab.addEventListener('click', function(e) {
                    // Ensure the link works properly
                    console.log('Expenses tab clicked - navigating to expenses page');
                    window.location.href = '{{ route("expenses.index") }}';
                });
                
                // Add hover effect to make it clear it's clickable
                expensesTab.style.cursor = 'pointer';
                expensesTab.style.pointerEvents = 'auto';
            }
        });

        // PWA Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    }, function(err) {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }

        // PWA Install Prompt
        let deferredPrompt;
        const installButton = document.createElement('button');
        installButton.textContent = 'Install OBADIA App';
        installButton.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            display: none;
            z-index: 1000;
        `;

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            installButton.style.display = 'block';
            document.body.appendChild(installButton);
        });

        installButton.addEventListener('click', (e) => {
            installButton.style.display = 'none';
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the A2HS prompt');
                } else {
                    console.log('User dismissed the A2HS prompt');
                }
                deferredPrompt = null;
            });
        });

        window.addEventListener('appinstalled', (evt) => {
            console.log('OBADIA PWA was installed');
        });
    </script>
</body>
</html>
