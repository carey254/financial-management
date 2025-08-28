<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OBADIA - Edit Budget Item</title>
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
            max-width: 800px;
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

        .back-btn {
            background: #718096;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .back-btn:hover {
            background: #4a5568;
            transform: translateY(-2px);
        }

        /* Main Content */
        .main-content {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-header h2 {
            color: #4a5568;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #718096;
            font-size: 1.1rem;
        }

        /* Current Budget Info */
        .budget-info {
            background: #e6fffa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #38b2ac;
            margin-bottom: 30px;
        }

        .budget-info h3 {
            color: #234e52;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .budget-info p {
            color: #285e61;
            margin: 5px 0;
        }

        /* Form Styles */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 600;
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        select.form-control {
            cursor: pointer;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Category Selection */
        .category-selection {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .category-option {
            position: relative;
        }

        .category-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .category-label {
            display: block;
            padding: 20px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            color: #4a5568;
        }

        .category-option input[type="radio"]:checked + .category-label {
            border-color: #667eea;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .category-label i {
            display: block;
            font-size: 1.5rem;
            margin-bottom: 8px;
        }

        /* Amount Input with Currency */
        .amount-input-group {
            position: relative;
        }

        .amount-input-group .currency-prefix {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
            font-weight: 600;
            z-index: 2;
        }

        .amount-input-group .form-control {
            padding-left: 50px;
        }

        /* Date Inputs */
        .date-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary {
            background: #718096;
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        /* Error Messages */
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .error-list {
            list-style: none;
            margin: 0;
        }

        .error-list li {
            margin-bottom: 5px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .main-content {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .category-selection {
                grid-template-columns: repeat(2, 1fr);
            }

            .date-grid {
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <h1><i class="fas fa-edit"></i> Edit Budget Item</h1>
            <a href="{{ route('budget.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Budget
            </a>
        </header>

        <!-- Main Content -->
        <div class="main-content">
            <div class="form-header">
                <h2>Edit Budget Item</h2>
                <p>Update your budget item details</p>
            </div>

            <!-- Current Budget Info -->
            <div class="budget-info">
                <h3><i class="fas fa-info-circle"></i> Current Budget Information</h3>
                <p><strong>Category:</strong> {{ $budget->category }}</p>
                <p><strong>Item:</strong> {{ $budget->item }}</p>
                <p><strong>Current Budgeted Amount:</strong> {{ number_format($budget->budgeted_amount, 2) }} KSH</p>
                <p><strong>Current Actual Amount:</strong> {{ number_format($budget->actual_amount, 2) }} KSH</p>
                <p><strong>Current Difference:</strong> 
                    <span class="{{ $budget->difference >= 0 ? 'positive' : 'negative' }}">
                        {{ $budget->difference >= 0 ? '+' : '' }}{{ number_format($budget->difference, 2) }} KSH
                    </span>
                </p>
                <p><strong>Month/Year:</strong> {{ date('F Y', mktime(0, 0, 0, $budget->month, 1, $budget->year)) }}</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <strong>Please fix the following errors:</strong>
                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('budget.update', $budget) }}" id="budgetForm">
                @csrf
                @method('PUT')

                <!-- Category Selection -->
                <div class="form-group">
                    <label>Select Category</label>
                    <div class="category-selection">
                        <div class="category-option">
                            <input type="radio" id="bills" name="category" value="Bills" 
                                   {{ old('category', $budget->category) == 'Bills' ? 'checked' : '' }} required>
                            <label for="bills" class="category-label">
                                <i class="fas fa-file-invoice-dollar"></i>
                                Bills
                            </label>
                        </div>
                        <div class="category-option">
                            <input type="radio" id="wants" name="category" value="Wants" 
                                   {{ old('category', $budget->category) == 'Wants' ? 'checked' : '' }} required>
                            <label for="wants" class="category-label">
                                <i class="fas fa-shopping-cart"></i>
                                Wants
                            </label>
                        </div>
                        <div class="category-option">
                            <input type="radio" id="savings" name="category" value="Savings" 
                                   {{ old('category', $budget->category) == 'Savings' ? 'checked' : '' }} required>
                            <label for="savings" class="category-label">
                                <i class="fas fa-piggy-bank"></i>
                                Savings
                            </label>
                        </div>
                        <div class="category-option">
                            <input type="radio" id="debts" name="category" value="Debts" 
                                   {{ old('category', $budget->category) == 'Debts' ? 'checked' : '' }} required>
                            <label for="debts" class="category-label">
                                <i class="fas fa-credit-card"></i>
                                Debts
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Budget Details -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="item">Item Name</label>
                        <input type="text" id="item" name="item" class="form-control" 
                               value="{{ old('item', $budget->item) }}" 
                               placeholder="e.g., Rent, Groceries, Entertainment..." required>
                    </div>

                    <div class="form-group">
                        <label for="budgeted_amount">Budgeted Amount</label>
                        <div class="amount-input-group">
                            <span class="currency-prefix">KSH</span>
                            <input type="number" id="budgeted_amount" name="budgeted_amount" 
                                   class="form-control" value="{{ old('budgeted_amount', $budget->budgeted_amount) }}" 
                                   min="0" step="0.01" max="999999.99" 
                                   placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="actual_amount">Actual Amount</label>
                        <div class="amount-input-group">
                            <span class="currency-prefix">KSH</span>
                            <input type="number" id="actual_amount" name="actual_amount" 
                                   class="form-control" value="{{ old('actual_amount', $budget->actual_amount) }}" 
                                   min="0" step="0.01" max="999999.99" 
                                   placeholder="0.00">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Month & Year</label>
                        <div class="date-grid">
                            <div>
                                <select id="month" name="month" class="form-control" required>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ old('month', $budget->month) == $i ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <select id="year" name="year" class="form-control" required>
                                    @for($year = date('Y') - 1; $year <= date('Y') + 2; $year++)
                                        <option value="{{ $year }}" {{ old('year', $budget->year) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="form-group full-width">
                    <label for="notes">Notes (Optional)</label>
                    <textarea id="notes" name="notes" class="form-control" 
                              placeholder="Any additional notes about this budget item...">{{ old('notes', $budget->notes) }}</textarea>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Budget Item
                    </button>
                    <a href="{{ route('budget.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <form method="POST" action="{{ route('budget.destroy', $budget) }}" 
                          style="display: inline;" 
                          onsubmit="return confirm('Are you sure you want to delete this budget item? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Budget Item
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Form validation
        document.getElementById('budgetForm').addEventListener('submit', function(e) {
            const category = document.querySelector('input[name="category"]:checked');
            const item = document.getElementById('item').value;
            const budgetedAmount = document.getElementById('budgeted_amount').value;

            if (!category) {
                e.preventDefault();
                alert('Please select a budget category (Bills, Wants, Savings, or Debts)');
                return;
            }

            if (!item.trim()) {
                e.preventDefault();
                alert('Please enter an item name');
                return;
            }

            if (!budgetedAmount || budgetedAmount <= 0) {
                e.preventDefault();
                alert('Please enter a valid budgeted amount');
                return;
            }
        });
    </script>
</body>
</html>
