<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OBADIA - Edit Task</title>
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

        /* Employer Selection */
        .employer-selection {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .employer-option {
            position: relative;
        }

        .employer-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .employer-label {
            display: block;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            color: #4a5568;
        }

        .employer-option input[type="radio"]:checked + .employer-label {
            border-color: #667eea;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        /* Calculation Display */
        .calculation-display {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
            margin-bottom: 30px;
        }

        .calculation-display h3 {
            color: #4a5568;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .calculation-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .calculation-total {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d3748;
            border-top: 2px solid #e2e8f0;
            padding-top: 15px;
            margin-top: 15px;
        }

        /* Status Selection */
        .status-selection {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .status-option {
            position: relative;
        }

        .status-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .status-label {
            display: block;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            color: #4a5568;
        }

        .status-option input[type="radio"]:checked + .status-label.pending {
            border-color: #ed8936;
            background: #fed7aa;
            color: #9c4221;
        }

        .status-option input[type="radio"]:checked + .status-label.paid {
            border-color: #48bb78;
            background: #c6f6d5;
            color: #22543d;
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

        /* Task Info */
        .task-info {
            background: #e6fffa;
            padding: 20px;
            border-radius: 10px;
            border-left: 4px solid #38b2ac;
            margin-bottom: 30px;
        }

        .task-info h3 {
            color: #234e52;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .task-info p {
            color: #285e61;
            margin: 5px 0;
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

            .employer-selection {
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
            <h1><i class="fas fa-edit"></i> Edit Task</h1>
            <a href="{{ route('tasks.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Tasks
            </a>
        </header>

        <!-- Main Content -->
        <div class="main-content">
            <div class="form-header">
                <h2>Edit Task</h2>
                <p>Update task details for {{ $task->employer }}</p>
            </div>

            <!-- Current Task Info -->
            <div class="task-info">
                <h3><i class="fas fa-info-circle"></i> Current Task Information</h3>
                <p><strong>Employer:</strong> {{ $task->employer }}</p>
                <p><strong>Original Amount:</strong> {{ number_format($task->amount, 2) }} KSH</p>
                <p><strong>Created:</strong> {{ $task->created_at->format('M d, Y \a\t g:i A') }}</p>
                <p><strong>Last Updated:</strong> {{ $task->updated_at->format('M d, Y \a\t g:i A') }}</p>
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

            <form method="POST" action="{{ route('tasks.update', $task) }}" id="taskForm">
                @csrf
                @method('PUT')

                <!-- Employer Selection -->
                <div class="form-group">
                    <label>Select Employer</label>
                    <div class="employer-selection">
                        <div class="employer-option">
                            <input type="radio" id="macflex" name="employer" value="MACFLEX" 
                                   {{ old('employer', $task->employer) == 'MACFLEX' ? 'checked' : '' }} required>
                            <label for="macflex" class="employer-label">MACFLEX</label>
                        </div>
                        <div class="employer-option">
                            <input type="radio" id="juja" name="employer" value="JUJA" 
                                   {{ old('employer', $task->employer) == 'JUJA' ? 'checked' : '' }} required>
                            <label for="juja" class="employer-label">JUJA</label>
                        </div>
                        <div class="employer-option">
                            <input type="radio" id="meru" name="employer" value="MERU" 
                                   {{ old('employer', $task->employer) == 'MERU' ? 'checked' : '' }} required>
                            <label for="meru" class="employer-label">MERU</label>
                        </div>
                    </div>
                </div>

                <!-- Task Details -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="task_description">Task Description</label>
                        <input type="text" id="task_description" name="task_description" 
                               class="form-control" value="{{ old('task_description', $task->task_description) }}" 
                               placeholder="e.g., Article writing, Blog post, Research..." required>
                    </div>

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" class="form-control" 
                               value="{{ old('date', $task->date->format('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="pages">Number of Pages</label>
                        <input type="number" id="pages" name="pages" class="form-control" 
                               value="{{ old('pages', $task->pages) }}" min="1" max="1000" 
                               placeholder="e.g., 5" required onchange="calculateAmount()">
                    </div>

                    <div class="form-group">
                        <label for="rate">Rate per Page ($)</label>
                        <input type="number" id="rate" name="rate" class="form-control" 
                               value="{{ old('rate', $task->rate) }}" min="0" step="0.01" max="1000" 
                               placeholder="e.g., 3.50" required onchange="calculateAmount()">
                    </div>
                </div>

                <!-- Calculation Display -->
                <div class="calculation-display" id="calculationDisplay">
                    <h3><i class="fas fa-calculator"></i> Updated Calculation</h3>
                    <div class="calculation-row">
                        <span>Pages:</span>
                        <span id="displayPages">{{ $task->pages }}</span>
                    </div>
                    <div class="calculation-row">
                        <span>Rate per Page:</span>
                        <span id="displayRate">{{ number_format($task->rate, 2) }} KSH</span>
                    </div>
                    <div class="calculation-row calculation-total">
                        <span>Total Amount:</span>
                        <span id="displayTotal">{{ number_format($task->amount, 2) }} KSH</span>
                    </div>
                </div>

                <!-- Payment Status -->
                <div class="form-group">
                    <label>Payment Status</label>
                    <div class="status-selection">
                        <div class="status-option">
                            <input type="radio" id="pending" name="status" value="pending" 
                                   {{ old('status', $task->status) == 'pending' ? 'checked' : '' }} required>
                            <label for="pending" class="status-label pending">
                                <i class="fas fa-clock"></i> Pending
                            </label>
                        </div>
                        <div class="status-option">
                            <input type="radio" id="paid" name="status" value="paid" 
                                   {{ old('status', $task->status) == 'paid' ? 'checked' : '' }} required>
                            <label for="paid" class="status-label paid">
                                <i class="fas fa-check-circle"></i> Paid
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div class="form-group full-width">
                    <label for="notes">Notes (Optional)</label>
                    <textarea id="notes" name="notes" class="form-control" 
                              placeholder="Any additional notes about this task...">{{ old('notes', $task->notes) }}</textarea>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Task
                    </button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <form method="POST" action="{{ route('tasks.destroy', $task) }}" 
                          style="display: inline;" 
                          onsubmit="return confirm('Are you sure you want to delete this task? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete Task
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>

    <script>
        function calculateAmount() {
            const pages = parseFloat(document.getElementById('pages').value) || 0;
            const rate = parseFloat(document.getElementById('rate').value) || 0;
            const total = pages * rate;

            document.getElementById('displayPages').textContent = pages.toLocaleString();
            document.getElementById('displayRate').textContent = '$' + rate.toFixed(2);
            document.getElementById('displayTotal').textContent = '$' + total.toFixed(2);
        }

        // Calculate on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateAmount();
        });

        // Form validation
        document.getElementById('taskForm').addEventListener('submit', function(e) {
            const employer = document.querySelector('input[name="employer"]:checked');
            const pages = document.getElementById('pages').value;
            const rate = document.getElementById('rate').value;
            const description = document.getElementById('task_description').value;

            if (!employer) {
                e.preventDefault();
                alert('Please select an employer (MACFLEX, JUJA, or MERU)');
                return;
            }

            if (!pages || pages <= 0) {
                e.preventDefault();
                alert('Please enter a valid number of pages');
                return;
            }

            if (!rate || rate <= 0) {
                e.preventDefault();
                alert('Please enter a valid rate per page');
                return;
            }

            if (!description.trim()) {
                e.preventDefault();
                alert('Please enter a task description');
                return;
            }
        });
    </script>
</body>
</html>
