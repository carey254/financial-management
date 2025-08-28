<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OBADIA - Budget Management</title>
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

        /* Month Selector */
        .month-selector {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .month-selector h3 {
            color: #4a5568;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .month-input {
            padding: 10px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
        }

        .month-input:focus {
            outline: none;
            border-color: #667eea;
        }

        /* Summary Cards */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border-left: 5px solid;
        }

        .summary-card.total {
            border-left-color: #667eea;
        }

        .summary-card.budgeted {
            border-left-color: #48bb78;
        }

        .summary-card.actual {
            border-left-color: #ed8936;
        }

        .summary-card.difference {
            border-left-color: #9f7aea;
        }

        .summary-card h3 {
            color: #4a5568;
            font-size: 1rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .summary-card .amount {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
        }

        .summary-card .currency {
            font-size: 1.2rem;
            color: #718096;
            margin-left: 5px;
        }

        /* Category Sections */
        .category-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .category-header {
            padding: 20px 30px;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .category-header h3 {
            color: #4a5568;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .category-summary {
            display: flex;
            gap: 20px;
            font-size: 0.9rem;
            color: #718096;
        }

        .category-summary span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Budget Table */
        .budget-table {
            width: 100%;
            border-collapse: collapse;
        }

        .budget-table th,
        .budget-table td {
            padding: 15px 20px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .budget-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #4a5568;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .budget-table td {
            color: #2d3748;
        }

        .budget-table tr:hover {
            background: #f8f9fa;
        }

        .amount-cell {
            font-weight: 600;
            font-family: 'Courier New', monospace;
        }

        .positive {
            color: #38a169;
        }

        .negative {
            color: #e53e3e;
        }

        .neutral {
            color: #718096;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        .btn-edit {
            background: #4299e1;
            color: white;
        }

        .btn-delete {
            background: #f56565;
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #718096;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #cbd5e0;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #4a5568;
        }

        .empty-state p {
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        /* Success/Error Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #c6f6d5;
            color: #22543d;
            border: 1px solid #9ae6b4;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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

            .summary-cards {
                grid-template-columns: 1fr;
            }

            .category-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .category-summary {
                flex-wrap: wrap;
            }

            .budget-table {
                font-size: 0.9rem;
            }

            .budget-table th,
            .budget-table td {
                padding: 10px;
            }

            .nav-tabs {
                flex-wrap: wrap;
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
        <!-- Navigation Tabs -->
        <div class="nav-tabs">
            <a href="{{ route('dashboard') }}" class="nav-tab">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('tasks.index') }}" class="nav-tab">
                <i class="fas fa-tasks"></i> Tasks
            </a>
            <a href="{{ route('budget.index') }}" class="nav-tab active">
                <i class="fas fa-wallet"></i> Budget
            </a>
            <a href="{{ route('expenses.index') }}" class="nav-tab">
                <i class="fas fa-receipt"></i> Expenses
            </a>
        </div>

        <!-- Header -->
        <header class="header">
            <h1><i class="fas fa-wallet"></i> Budget Management</h1>
            <div class="header-actions">
                <a href="{{ route('budget.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Budget Item
                </a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Month Selector -->
        <div class="month-selector">
            <h3><i class="fas fa-calendar-alt"></i> Select Month</h3>
            <input type="month" id="monthSelector" class="month-input" value="{{ $currentMonth }}" onchange="changeMonth()">
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card total">
                <h3><i class="fas fa-chart-line"></i> Total Budget</h3>
                <div class="amount">{{ number_format($totalBudgeted, 2) }}<span class="currency">KSH</span></div>
            </div>
            <div class="summary-card budgeted">
                <h3><i class="fas fa-piggy-bank"></i> Budgeted</h3>
                <div class="amount">{{ number_format($totalBudgeted, 2) }}<span class="currency">KSH</span></div>
            </div>
            <div class="summary-card actual">
                <h3><i class="fas fa-money-bill-wave"></i> Actual Spent</h3>
                <div class="amount">{{ number_format($totalActual, 2) }}<span class="currency">KSH</span></div>
            </div>
            <div class="summary-card difference">
                <h3><i class="fas fa-balance-scale"></i> Difference</h3>
                <div class="amount {{ $totalDifference >= 0 ? 'positive' : 'negative' }}">
                    {{ $totalDifference >= 0 ? '+' : '' }}{{ number_format($totalDifference, 2) }}<span class="currency">KSH</span>
                </div>
            </div>
        </div>

        <!-- Budget Categories -->
        @foreach($categories as $category)
            <div class="category-section">
                <div class="category-header">
                    <h3>
                        @if($category == 'Bills')
                            <i class="fas fa-file-invoice-dollar"></i>
                        @elseif($category == 'Wants')
                            <i class="fas fa-shopping-cart"></i>
                        @elseif($category == 'Savings')
                            <i class="fas fa-piggy-bank"></i>
                        @else
                            <i class="fas fa-credit-card"></i>
                        @endif
                        {{ $category }}
                    </h3>
                    <div class="category-summary">
                        <span>
                            <i class="fas fa-coins"></i>
                            Budgeted: {{ number_format($categorySummaries[$category]['budgeted'], 2) }} KSH
                        </span>
                        <span>
                            <i class="fas fa-money-bill"></i>
                            Actual: {{ number_format($categorySummaries[$category]['actual'], 2) }} KSH
                        </span>
                        <span class="{{ $categorySummaries[$category]['difference'] >= 0 ? 'positive' : 'negative' }}">
                            <i class="fas fa-balance-scale"></i>
                            Difference: {{ $categorySummaries[$category]['difference'] >= 0 ? '+' : '' }}{{ number_format($categorySummaries[$category]['difference'], 2) }} KSH
                        </span>
                        <span>
                            <i class="fas fa-list"></i>
                            Items: {{ $categorySummaries[$category]['count'] }}
                        </span>
                    </div>
                </div>

                @if($budgets->has($category) && $budgets[$category]->count() > 0)
                    <table class="budget-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Budgeted Amount</th>
                                <th>Actual Amount</th>
                                <th>Difference</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($budgets[$category] as $budget)
                                <tr>
                                    <td>
                                        <strong>{{ $budget->item }}</strong>
                                    </td>
                                    <td class="amount-cell">{{ number_format($budget->budgeted_amount, 2) }} KSH</td>
                                    <td class="amount-cell">{{ number_format($budget->actual_amount, 2) }} KSH</td>
                                    <td class="amount-cell {{ $budget->difference >= 0 ? 'positive' : 'negative' }}">
                                        {{ $budget->difference >= 0 ? '+' : '' }}{{ number_format($budget->difference, 2) }} KSH
                                    </td>
                                    <td>{{ $budget->notes ?: '-' }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('budget.edit', $budget) }}" class="btn btn-edit btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form method="POST" action="{{ route('budget.destroy', $budget) }}" 
                                                  style="display: inline;" 
                                                  onsubmit="return confirm('Are you sure you want to delete this budget item?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-delete btn-sm">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>No {{ $category }} Items</h3>
                        <p>You haven't added any {{ strtolower($category) }} items for this month yet.</p>
                        <a href="{{ route('budget.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add {{ $category }} Item
                        </a>
                    </div>
                @endif
            </div>
        @endforeach

        @if($budgets->isEmpty())
            <div class="category-section">
                <div class="empty-state">
                    <i class="fas fa-wallet"></i>
                    <h3>No Budget Items</h3>
                    <p>You haven't created any budget items for {{ date('F Y', strtotime($currentMonth)) }} yet.</p>
                    <a href="{{ route('budget.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create Your First Budget Item
                    </a>
                </div>
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
        function changeMonth() {
            const selectedMonth = document.getElementById('monthSelector').value;
            window.location.href = `{{ route('budget.index') }}?month=${selectedMonth}`;
        }

        // Auto-refresh data when month changes
        document.addEventListener('DOMContentLoaded', function() {
            const monthSelector = document.getElementById('monthSelector');
            monthSelector.addEventListener('change', changeMonth);
        });
    </script>
</body>
</html>
