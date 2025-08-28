<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OBADIA - Expense Management</title>
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

        /* Navigation Tabs */
        .nav-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .nav-tab {
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.7);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            color: #4a5568;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-tab:hover,
        .nav-tab.active {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
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

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary {
            background: #718096;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Coming Soon Section */
        .coming-soon {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .coming-soon i {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 30px;
        }

        .coming-soon h2 {
            color: #4a5568;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .coming-soon p {
            color: #718096;
            font-size: 1.2rem;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .features-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 40px;
            text-align: left;
        }

        .feature-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }

        .feature-item h3 {
            color: #4a5568;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .feature-item p {
            color: #718096;
            font-size: 0.95rem;
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

            .header-actions {
                flex-wrap: wrap;
                justify-content: center;
            }

            .coming-soon {
                padding: 40px 20px;
            }

            .coming-soon h2 {
                font-size: 2rem;
            }

            .features-list {
                grid-template-columns: 1fr;
            }

            .nav-tabs {
                flex-wrap: wrap;
            }
        }

        /* Additional Expense Styles */
        .month-selector {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .month-selector label {
            color: #4a5568;
            font-weight: 600;
            margin-right: 15px;
        }

        .month-selector select {
            padding: 8px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .summary-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 1.2rem;
        }

        .summary-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
        }

        .summary-label {
            color: #718096;
            font-size: 0.9rem;
        }

        .category-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .category-bills { background: #fed7d7; color: #c53030; }
        .category-wants { background: #c6f6d5; color: #2f855a; }
        .category-savings { background: #bee3f8; color: #2b6cb0; }
        .category-debts { background: #faf089; color: #b7791f; }

        .necessity-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .necessity-badge.necessary { background: #fed7d7; color: #c53030; }
        .necessity-badge.optional { background: #c6f6d5; color: #2f855a; }

        .status-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-recorded { background: #bee3f8; color: #2b6cb0; }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 6px 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: #bee3f8;
            color: #2b6cb0;
        }

        .btn-delete {
            background: #fed7d7;
            color: #c53030;
        }

        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .empty-state {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 60px 30px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .empty-state i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #4a5568;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #718096;
            margin-bottom: 20px;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
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
        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <a href="{{ route('dashboard') }}" class="nav-tab">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('tasks.index') }}" class="nav-tab">
                <i class="fas fa-tasks"></i> Tasks
            </a>
            <a href="{{ route('budget.index') }}" class="nav-tab">
                <i class="fas fa-wallet"></i> Budget
            </a>
            <a href="{{ route('expenses.index') }}" class="nav-tab active">
                <i class="fas fa-receipt"></i> Expenses
            </a>
        </div>

        <!-- Header -->
        <header class="header">
            <h1><i class="fas fa-receipt"></i> Expense Management</h1>
            <div class="header-actions">
                <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Expense
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Month Selector -->
        <div class="month-selector">
            <label for="monthSelector">Select Month:</label>
            <select id="monthSelector" onchange="changeMonth()">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ date('Y') }}-{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" 
                            {{ (isset($currentMonth) && $currentMonth == date('Y') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT)) || (!isset($currentMonth) && $i == date('n')) ? 'selected' : '' }}>
                        {{ date('F Y', mktime(0, 0, 0, $i, 1, date('Y'))) }}
                    </option>
                @endfor
            </select>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Expense Summary -->
        <div class="summary-section">
            <h3 style="color: #4a5568; margin-bottom: 20px; font-size: 1.3rem;">
                <i class="fas fa-chart-bar"></i> Expense Summary
            </h3>
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-value">{{ isset($expenses) ? $expenses->count() : 0 }}</div>
                        <div class="summary-label">Total Expenses</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-value">{{ number_format(isset($expenses) ? $expenses->sum('amount') : 0, 2) }} KSH</div>
                        <div class="summary-label">Total Amount</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-value">{{ number_format(isset($expenses) ? $expenses->where('necessary', 1)->sum('amount') : 0, 2) }} KSH</div>
                        <div class="summary-label">Necessary</div>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="summary-content">
                        <div class="summary-value">{{ number_format(isset($expenses) ? $expenses->where('necessary', 0)->sum('amount') : 0, 2) }} KSH</div>
                        <div class="summary-label">Optional</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expenses Table -->
        @if(isset($expenses) && $expenses->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Necessity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expenses as $expense)
                            <tr>
                                <td>{{ date('M d, Y', strtotime($expense->date)) }}</td>
                                <td>{{ $expense->item }}</td>
                                <td>
                                    <span class="category-badge category-{{ strtolower($expense->category) }}">
                                        @if($expense->category == 'Bills')
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        @elseif($expense->category == 'Wants')
                                            <i class="fas fa-shopping-cart"></i>
                                        @elseif($expense->category == 'Savings')
                                            <i class="fas fa-piggy-bank"></i>
                                        @elseif($expense->category == 'Debts')
                                            <i class="fas fa-credit-card"></i>
                                        @endif
                                        {{ $expense->category }}
                                    </span>
                                </td>
                                <td class="amount">{{ number_format($expense->amount, 2) }} KSH</td>
                                <td>
                                    <span class="necessity-badge {{ $expense->necessary ? 'necessary' : 'optional' }}">
                                        @if($expense->necessary)
                                            <i class="fas fa-exclamation-circle"></i> Necessary
                                        @else
                                            <i class="fas fa-heart"></i> Optional
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($expense->status ?? 'recorded') }}">
                                        {{ ucfirst($expense->status ?? 'Recorded') }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-edit" title="Edit Expense">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-action btn-delete" title="Delete Expense">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h3>No Expenses Found</h3>
                <p>You haven't recorded any expenses for this month yet.</p>
                <a href="{{ route('expenses.create') }}" class="btn btn-primary" style="margin-top: 20px;">
                    <i class="fas fa-plus"></i> Add Your First Expense
                </a>
            </div>
        @endif
        
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
            const selectedMonth = document.getElementById('monthSelector').value;
            window.location.href = `{{ route('expenses.index') }}?month=${selectedMonth}`;
        }

        // Auto-refresh data when month changes
        document.addEventListener('DOMContentLoaded', function() {
            const monthSelector = document.getElementById('monthSelector');
            monthSelector.addEventListener('change', changeMonth);
        });
    </script>
</body>
</html>
