<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OBADIA - Add Expense</title>
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
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 20px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
        }

        .header h1 {
            color: #2d3748;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .back-btn {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: #764ba2;
            transform: translateY(-2px);
        }

        .main-content {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(10px);
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h2 {
            color: #2d3748;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #718096;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .category-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 10px;
        }

        .category-option {
            position: relative;
        }

        .category-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .category-option label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .category-option input[type="radio"]:checked + label {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .category-icon {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .necessity-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 10px;
        }

        .necessity-option {
            position: relative;
        }

        .necessity-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .necessity-option label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .necessity-option input[type="radio"]:checked + label {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .status-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 10px;
        }

        .status-option {
            position: relative;
        }

        .status-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .status-option label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .status-option input[type="radio"]:checked + label {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .amount-input-group {
            position: relative;
        }

        .amount-input-group::before {
            content: 'KSH';
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
            font-weight: 600;
            z-index: 1;
        }

        .amount-input-group .form-control {
            padding-left: 50px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #4a5568;
        }

        .btn-secondary:hover {
            background: #cbd5e0;
            transform: translateY(-2px);
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-danger {
            background: #fed7d7;
            color: #c53030;
            border: 1px solid #feb2b2;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .category-options {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
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

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
                padding: 15px 20px;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .main-content {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .category-options {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }

            .category-option {
                padding: 12px;
            }

            .category-icon {
                font-size: 1.2rem;
            }

            .form-actions {
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .footer-content {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 480px) {
            .category-options {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 1.3rem;
            }

            .form-header h2 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <h1><i class="fas fa-plus-circle"></i> Add Expense</h1>
            <a href="{{ route('expenses.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Expenses
            </a>
        </header>

        <div class="main-content">
            <div class="form-header">
                <h2>Record New Expense</h2>
                <p>Add a new expense to track your spending</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Please fix the following errors:</strong>
                        <ul style="margin: 5px 0 0 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('expenses.store') }}" id="expenseForm">
                @csrf

                <!-- Category Selection -->
                <div class="form-group">
                    <label>Expense Category</label>
                    <div class="category-options">
                        <div class="category-option">
                            <input type="radio" id="bills" name="category" value="Bills" {{ old('category') == 'Bills' ? 'checked' : '' }}>
                            <label for="bills">
                                <i class="fas fa-file-invoice-dollar category-icon" style="color: #e53e3e;"></i>
                                <span>Bills</span>
                            </label>
                        </div>
                        <div class="category-option">
                            <input type="radio" id="wants" name="category" value="Wants" {{ old('category') == 'Wants' ? 'checked' : '' }}>
                            <label for="wants">
                                <i class="fas fa-shopping-cart category-icon" style="color: #38a169;"></i>
                                <span>Wants</span>
                            </label>
                        </div>
                        <div class="category-option">
                            <input type="radio" id="savings" name="category" value="Savings" {{ old('category') == 'Savings' ? 'checked' : '' }}>
                            <label for="savings">
                                <i class="fas fa-piggy-bank category-icon" style="color: #3182ce;"></i>
                                <span>Savings</span>
                            </label>
                        </div>
                        <div class="category-option">
                            <input type="radio" id="debts" name="category" value="Debts" {{ old('category') == 'Debts' ? 'checked' : '' }}>
                            <label for="debts">
                                <i class="fas fa-credit-card category-icon" style="color: #d69e2e;"></i>
                                <span>Debts</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Expense Details -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="item">Expense Item</label>
                        <input type="text" id="item" name="item" class="form-control" 
                               value="{{ old('item') }}" 
                               placeholder="e.g., Electricity Bill, Groceries, etc." required>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount (KSH)</label>
                        <div class="amount-input-group">
                            <input type="number" id="amount" name="amount" class="form-control" 
                                   value="{{ old('amount') }}" 
                                   step="0.01" min="0" placeholder="0.00" required>
                        </div>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="date">Expense Date</label>
                        <input type="date" id="date" name="date" class="form-control" 
                               value="{{ old('date', date('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Necessity</label>
                        <div class="necessity-options">
                            <div class="necessity-option">
                                <input type="radio" id="necessary" name="necessary" value="1" {{ old('necessary', '1') == '1' ? 'checked' : '' }}>
                                <label for="necessary">
                                    <i class="fas fa-exclamation-circle" style="color: #e53e3e;"></i>
                                    <span>Necessary</span>
                                </label>
                            </div>
                            <div class="necessity-option">
                                <input type="radio" id="optional" name="necessary" value="0" {{ old('necessary') == '0' ? 'checked' : '' }}>
                                <label for="optional">
                                    <i class="fas fa-heart" style="color: #38a169;"></i>
                                    <span>Optional</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Status -->
                <div class="form-group">
                    <label>Payment Status</label>
                    <div class="status-options">
                        <div class="status-option">
                            <input type="radio" id="paid" name="status" value="paid" {{ old('status', 'paid') == 'paid' ? 'checked' : '' }}>
                            <label for="paid">
                                <i class="fas fa-check-circle" style="color: #38a169;"></i>
                                <span>Paid</span>
                            </label>
                        </div>
                        <div class="status-option">
                            <input type="radio" id="pending" name="status" value="pending" {{ old('status') == 'pending' ? 'checked' : '' }}>
                            <label for="pending">
                                <i class="fas fa-clock" style="color: #ed8936;"></i>
                                <span>Pending</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="form-group">
                    <label for="notes">Notes (Optional)</label>
                    <textarea id="notes" name="notes" class="form-control" rows="3" 
                              placeholder="Additional details about this expense...">{{ old('notes') }}</textarea>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Record Expense
                    </button>
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
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
        // Form validation
        document.getElementById('expenseForm').addEventListener('submit', function(e) {
            const category = document.querySelector('input[name="category"]:checked');
            const status = document.querySelector('input[name="status"]:checked');
            const item = document.getElementById('item').value;
            const amount = document.getElementById('amount').value;

            if (!category) {
                e.preventDefault();
                alert('Please select an expense category (Bills, Wants, Savings, or Debts)');
                return;
            }

            if (!status) {
                e.preventDefault();
                alert('Please select payment status (Paid or Pending)');
                return;
            }

            if (!item.trim()) {
                e.preventDefault();
                alert('Please enter an expense item description');
                document.getElementById('item').focus();
                return;
            }

            if (!amount || parseFloat(amount) <= 0) {
                e.preventDefault();
                alert('Please enter a valid expense amount');
                document.getElementById('amount').focus();
                return;
            }
        });

        // Auto-focus on form load
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('item').focus();
        });
    </script>
</body>
</html>
