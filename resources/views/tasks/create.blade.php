<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OBADIA - Add New Task</title>
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
        .default-employers-section {
            margin-bottom: 25px;
        }
        
        .additional-employers-section {
            margin-bottom: 20px;
        }
        
        .new-employer-section {
            margin-bottom: 25px;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        
        .new-employer-input {
            margin-top: 10px;
        }
        
        .new-employer-input input {
            border: 2px solid #cbd5e0;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .new-employer-input input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }
        
        .new-employer-input .form-text {
            margin-top: 8px;
            color: #6b7280;
            font-size: 0.875rem;
        }
        
        .section-subtitle {
            color: #4a5568;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .section-subtitle::before {
            content: '';
            width: 3px;
            height: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
        }
        
        .employer-selection {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
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
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }
        
        .employer-label strong {
            font-size: 1.1rem;
            color: #2d3748;
        }
        
        .employer-label small {
            color: #667eea;
            font-weight: 500;
            font-size: 0.85rem;
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
            <h1><i class="fas fa-plus-circle"></i> Add New Task</h1>
            <a href="{{ route('tasks.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Tasks
            </a>
        </header>

        <!-- Main Content -->
        <div class="main-content">
            <div class="form-header">
                <h2>Create New Task</h2>
                <p>Add a new task for any of your employers - choose from main employers or additional employers</p>
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

            <form method="POST" action="{{ route('tasks.store') }}" id="taskForm">
                @csrf

                <!-- Employer Selection -->
                <div class="form-group">
                    <label>Select Employer *</label>
                    
                    <!-- Quick Select Default Employers -->
                    <div class="default-employers-section">
                        <h4 class="section-subtitle">Main Employers</h4>
                        <div class="employer-selection">
                            @php
                                // Get default employers or create fallback options
                                $defaultEmployerNames = ['JUJA', 'MACFLEX', 'MERU'];
                                $defaultEmployers = collect();
                                
                                foreach($defaultEmployerNames as $name) {
                                    $employer = $employers->where('name', $name)->first();
                                    if ($employer) {
                                        $defaultEmployers->push($employer);
                                    } else {
                                        // Create temporary object for display
                                        $defaultEmployers->push((object)[
                                            'id' => strtolower($name),
                                            'name' => $name,
                                            'default_rate' => null,
                                            'is_fallback' => true
                                        ]);
                                    }
                                }
                            @endphp
                            
                            @foreach($defaultEmployers as $employer)
                                <div class="employer-option">
                                    <input type="radio" id="employer_{{ $employer->id }}" name="employer_id" 
                                           value="{{ $employer->id }}" 
                                           {{ old('employer_id') == $employer->id ? 'checked' : '' }}>
                                    <label for="employer_{{ $employer->id }}" class="employer-label">
                                        <strong>{{ $employer->name }}</strong>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Additional Employers Dropdown -->
                    @php
                        $additionalEmployers = $employers->whereNotIn('name', ['JUJA', 'MACFLEX', 'MERU']);
                    @endphp
                    
                    @if($additionalEmployers->count() > 0)
                        <div class="additional-employers-section">
                            <h4 class="section-subtitle">Additional Employers</h4>
                            <select id="additional_employer_select" class="form-control" onchange="selectAdditionalEmployer()">
                                <option value="">-- Or choose from additional employers --</option>
                                @foreach($additionalEmployers as $employer)
                                    <option value="{{ $employer->id }}" 
                                            data-rate="{{ $employer->default_rate }}"
                                            data-name="{{ $employer->name }}">
                                        {{ $employer->name }}
                                        @if($employer->default_rate)
                                            (KSH {{ number_format($employer->default_rate, 2) }}/page)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    
                    <!-- Add New Employer Option -->
                    <div class="new-employer-section">
                        <h4 class="section-subtitle">Or Add New Employer</h4>
                        <div class="new-employer-input">
                            <input type="text" id="new_employer_name" class="form-control" 
                                   placeholder="Enter new employer name (e.g., ABC Company)" 
                                   onchange="selectNewEmployer()" onkeyup="selectNewEmployer()">
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Type a new employer name to create a task for someone not in your list
                            </small>
                        </div>
                    </div>
                    
                    @if($employers->count() == 0)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>No employers found!</strong> 
                            <a href="{{ route('settings.index') }}" class="alert-link">Add employers in Settings</a> or use the "Add New Employer" field above.
                        </div>
                    @endif
                </div>

                <!-- Task Details -->
                <div class="form-grid">
                    <div class="form-group">
                        <label for="task_description">Task Description</label>
                        <input type="text" id="task_description" name="task_description" 
                               class="form-control" value="{{ old('task_description') }}" 
                               placeholder="e.g., Article writing, Blog post, Research..." required>
                    </div>

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" class="form-control" 
                               value="{{ old('date', date('Y-m-d')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="pages">Number of Pages</label>
                        <input type="number" id="pages" name="pages" class="form-control" 
                               value="{{ old('pages') }}" min="1" max="1000" 
                               placeholder="e.g., 5" required onchange="calculateAmount()">
                    </div>

                    <div class="form-group">
                        <label for="rate">Rate per Page (KSH)</label>
                        <input type="number" id="rate" name="rate" class="form-control" 
                               value="{{ old('rate') }}" min="0" step="0.01" max="1000" 
                               placeholder="e.g., 3.50" required onchange="calculateAmount()">
                    </div>
                </div>

                <!-- Calculation Display -->
                <div class="calculation-display" id="calculationDisplay" style="display: none;">
                    <h3><i class="fas fa-calculator"></i> Calculation</h3>
                    <div class="calculation-row">
                        <span>Pages:</span>
                        <span id="displayPages">0</span>
                    </div>
                    <div class="calculation-row">
                        <span>Rate per Page:</span>
                        <span id="displayRate">KSH 0.00</span>
                    </div>
                    <div class="calculation-row calculation-total">
                        <span>Total Amount:</span>
                        <span id="displayTotal">KSH 0.00</span>
                    </div>
                </div>

                <!-- Payment Status -->
                <div class="form-group">
                    <label>Payment Status</label>
                    <div class="status-selection">
                        <div class="status-option">
                            <input type="radio" id="pending" name="status" value="pending" 
                                   {{ old('status', 'pending') == 'pending' ? 'checked' : '' }} required>
                            <label for="pending" class="status-label pending">
                                <i class="fas fa-clock"></i> Pending
                            </label>
                        </div>
                        <div class="status-option">
                            <input type="radio" id="paid" name="status" value="paid" 
                                   {{ old('status') == 'paid' ? 'checked' : '' }} required>
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
                              placeholder="Any additional notes about this task...">{{ old('notes') }}</textarea>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Task
                    </button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function calculateAmount() {
            const pages = parseFloat(document.getElementById('pages').value) || 0;
            const rate = parseFloat(document.getElementById('rate').value) || 0;
            const amount = pages * rate;
            
            if (pages > 0 && rate > 0) {
                document.getElementById('calculationDisplay').style.display = 'block';
                document.getElementById('displayPages').textContent = pages;
                document.getElementById('displayRate').textContent = 'KSH ' + (rate % 1 === 0 ? rate : rate.toFixed(2));
                document.getElementById('displayTotal').textContent = 'KSH ' + (amount % 1 === 0 ? amount : amount.toFixed(2));
            } else {
                document.getElementById('calculationDisplay').style.display = 'none';
            }
        }
        
        // No longer needed since we removed default rates
        function updateDefaultRate() {
            // Just calculate amount when employer changes
            calculateAmount();
        }
        
        function selectAdditionalEmployer() {
            const additionalSelect = document.getElementById('additional_employer_select');
            const rateInput = document.getElementById('rate');
            
            if (additionalSelect.value) {
                // Clear main employer radio buttons
                const radioButtons = document.querySelectorAll('input[name="employer_id"]');
                radioButtons.forEach(radio => radio.checked = false);
                
                // Create a hidden input for the selected additional employer
                let hiddenInput = document.getElementById('selected_employer_id');
                if (!hiddenInput) {
                    hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.id = 'selected_employer_id';
                    hiddenInput.name = 'employer_id';
                    document.getElementById('taskForm').appendChild(hiddenInput);
                }
                hiddenInput.value = additionalSelect.value;
                
                // Update rate with selected employer's default rate (if any)
                const selectedOption = additionalSelect.options[additionalSelect.selectedIndex];
                const defaultRate = selectedOption.getAttribute('data-rate');
                
                if (defaultRate && defaultRate > 0) {
                    rateInput.value = defaultRate;
                } else {
                    // Clear rate field if no default rate
                    rateInput.value = '';
                }
                calculateAmount();
                
                // Show selected employer name
                const employerName = selectedOption.getAttribute('data-name');
                showSelectedEmployer(employerName);
            } else {
                // Remove hidden input if no additional employer selected
                const hiddenInput = document.getElementById('selected_employer_id');
                if (hiddenInput) {
                    hiddenInput.remove();
                }
                hideSelectedEmployer();
            }
        }
        
        function showSelectedEmployer(name) {
            let selectedDiv = document.getElementById('selected_employer_display');
            if (!selectedDiv) {
                selectedDiv = document.createElement('div');
                selectedDiv.id = 'selected_employer_display';
                selectedDiv.className = 'selected-employer-display';
                document.querySelector('.additional-employers-section').appendChild(selectedDiv);
            }
            selectedDiv.innerHTML = `
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <strong>Selected:</strong> ${name}
                    <button type="button" class="btn btn-sm btn-outline-secondary ml-2" onclick="clearAdditionalSelection()"
                            style="margin-left: 10px; padding: 2px 8px; font-size: 0.8rem;">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>
            `;
        }
        
        function hideSelectedEmployer() {
            const selectedDiv = document.getElementById('selected_employer_display');
            if (selectedDiv) {
                selectedDiv.remove();
            }
        }
        
        function clearAdditionalSelection() {
            const additionalSelect = document.getElementById('additional_employer_select');
            additionalSelect.value = '';
            selectAdditionalEmployer(); // This will clean up the hidden input and display
        }
        
        // Clear additional employer selection when a main employer is selected
        function clearAdditionalWhenMainSelected() {
            const additionalSelect = document.getElementById('additional_employer_select');
            if (additionalSelect) {
                additionalSelect.value = '';
            }
            
            const hiddenInput = document.getElementById('selected_employer_id');
            if (hiddenInput) {
                hiddenInput.remove();
            }
            
            hideSelectedEmployer();
        }
        
        function selectNewEmployer() {
            const newEmployerInput = document.getElementById('new_employer_name');
            const employerName = newEmployerInput.value.trim();
            
            if (employerName) {
                // Clear all other employer selections
                const radioButtons = document.querySelectorAll('input[name="employer_id"]');
                radioButtons.forEach(radio => radio.checked = false);
                
                const additionalSelect = document.getElementById('additional_employer_select');
                if (additionalSelect) {
                    additionalSelect.value = '';
                }
                
                // Remove any existing hidden inputs
                const existingHidden = document.getElementById('selected_employer_id');
                if (existingHidden) {
                    existingHidden.remove();
                }
                
                const existingNewEmployer = document.getElementById('new_employer_input');
                if (existingNewEmployer) {
                    existingNewEmployer.remove();
                }
                
                // Create hidden input for new employer name
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.id = 'new_employer_input';
                hiddenInput.name = 'employer_id';
                hiddenInput.value = 'new:' + employerName; // Prefix with 'new:' to identify as new employer
                document.getElementById('taskForm').appendChild(hiddenInput);
                
                // Clear rate field since new employer has no default rate
                const rateInput = document.getElementById('rate');
                if (rateInput && !rateInput.value) {
                    rateInput.value = '';
                }
                
                // Show confirmation
                showNewEmployerSelected(employerName);
                
                hideSelectedEmployer(); // Clear any additional employer display
            } else {
                // Remove hidden input if field is empty
                const hiddenInput = document.getElementById('new_employer_input');
                if (hiddenInput) {
                    hiddenInput.remove();
                }
                hideNewEmployerSelected();
            }
        }
        
        function showNewEmployerSelected(name) {
            let selectedDiv = document.getElementById('new_employer_display');
            if (!selectedDiv) {
                selectedDiv = document.createElement('div');
                selectedDiv.id = 'new_employer_display';
                selectedDiv.className = 'selected-employer-display';
                document.querySelector('.new-employer-section').appendChild(selectedDiv);
            }
            selectedDiv.innerHTML = `
                <div class="alert alert-success" style="margin-top: 15px;">
                    <i class="fas fa-check-circle"></i>
                    <strong>New Employer Selected:</strong> ${name}
                    <button type="button" class="btn btn-sm btn-outline-secondary ml-2" onclick="clearNewEmployer()"
                            style="margin-left: 10px; padding: 2px 8px; font-size: 0.8rem;">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>
            `;
        }
        
        function hideNewEmployerSelected() {
            const selectedDiv = document.getElementById('new_employer_display');
            if (selectedDiv) {
                selectedDiv.remove();
            }
        }
        
        function clearNewEmployer() {
            const newEmployerInput = document.getElementById('new_employer_name');
            newEmployerInput.value = '';
            selectNewEmployer(); // This will clean up the hidden input and display
        }
        
        // Clear new employer when other employers are selected
        function clearNewEmployerWhenOthersSelected() {
            const newEmployerInput = document.getElementById('new_employer_name');
            if (newEmployerInput) {
                newEmployerInput.value = '';
            }
            
            const hiddenInput = document.getElementById('new_employer_input');
            if (hiddenInput) {
                hiddenInput.remove();
            }
            
            hideNewEmployerSelected();
        }
        
        // Add event listeners to radio buttons
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('input[name="employer_id"]');
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        clearAdditionalWhenMainSelected();
                        clearNewEmployerWhenOthersSelected();
                        updateDefaultRate();
                    }
                });
            });
        });

        // Calculate on page load if values exist
        document.addEventListener('DOMContentLoaded', function() {
            calculateAmount();
        });

        // Form validation
        document.getElementById('taskForm').addEventListener('submit', function(e) {
            const employer = document.querySelector('input[name="employer_id"]:checked') || 
                           document.getElementById('selected_employer_id') ||
                           document.getElementById('new_employer_input');
            const newEmployerName = document.getElementById('new_employer_name').value.trim();
            const pages = document.getElementById('pages').value;
            const rate = document.getElementById('rate').value;
            const description = document.getElementById('task_description').value;

            // Check if any employer is selected (radio button, dropdown, or new employer name)
            if (!employer && !newEmployerName) {
                e.preventDefault();
                alert('Please select an employer or enter a new employer name');
                return;
            }
            
            // If employer is selected but no value, it's invalid
            if (employer && !employer.checked && !employer.value) {
                e.preventDefault();
                alert('Please select an employer or enter a new employer name');
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
