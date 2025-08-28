<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OBADIA - User Settings</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#764ba2">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="OBADIA">
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
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Navigation Tabs */
        .nav-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
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
            display: flex;
            align-items: center;
            gap: 8px;
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

        /* Main Content */
        .main-content {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        /* Settings Sections */
        .settings-section {
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid #e2e8f0;
        }

        .settings-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .section-title {
            color: #2d3748;
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #667eea;
        }

        /* Form Styles */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
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

        /* Buttons */
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 1rem;
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
        }

        .btn-danger {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 101, 101, 0.3);
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(72, 187, 120, 0.1);
            border: 1px solid rgba(72, 187, 120, 0.3);
            color: #2f855a;
        }

        .alert-danger {
            background: rgba(245, 101, 101, 0.1);
            border: 1px solid rgba(245, 101, 101, 0.3);
            color: #c53030;
        }

        /* User Info Card */
        .user-info-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .user-details h3 {
            margin-bottom: 5px;
            font-size: 1.2rem;
        }

        .user-details p {
            opacity: 0.9;
            font-size: 0.9rem;
        }

        /* Preferences Options */
        .preference-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .preference-option {
            position: relative;
        }

        .preference-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .preference-option label {
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

        .preference-option input[type="radio"]:checked + label {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #667eea;
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

            .nav-tabs {
                flex-direction: column;
                gap: 5px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .user-info-card {
                flex-direction: column;
                text-align: center;
            }

            .preference-options {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 1.3rem;
            }

            .section-title {
                font-size: 1.2rem;
            }
        }

        /* Employer Management Styles */
        .subsection-title {
            color: #4a5568;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .subsection-title i {
            color: #667eea;
        }

        .employer-form-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #667eea;
        }

        .employers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .employer-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
            position: relative;
        }

        .employer-card:hover {
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.1);
        }

        .employer-card.inactive {
            opacity: 0.7;
            border-color: #cbd5e0;
        }

        .employer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .employer-header h4 {
            color: #2d3748;
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .status-badge.active {
            background: rgba(72, 187, 120, 0.1);
            color: #2f855a;
        }

        .status-badge.inactive {
            background: rgba(160, 174, 192, 0.1);
            color: #718096;
        }

        .employer-details {
            margin-bottom: 15px;
        }

        .employer-details p {
            margin: 8px 0;
            color: #4a5568;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .employer-details i {
            color: #667eea;
            width: 16px;
            text-align: center;
        }

        .employer-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.85rem;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #718096;
        }

        .empty-state i {
            color: #cbd5e0;
            margin-bottom: 15px;
        }

        .empty-state h4 {
            color: #4a5568;
            margin-bottom: 10px;
        }

        .text-muted {
            color: #718096;
            font-size: 0.85rem;
        }

        /* Edit Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
        }

        .modal-header h3 {
            color: #2d3748;
            font-size: 1.4rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #718096;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            background: #f7fafc;
            color: #2d3748;
        }

        /* Mobile Responsiveness for Employer Management */
        @media (max-width: 768px) {
            .employers-grid {
                grid-template-columns: 1fr;
            }

            .employer-form-section {
                padding: 15px;
            }

            .employer-actions {
                justify-content: space-between;
            }

            .modal-content {
                width: 95%;
                padding: 20px;
            }
        }

        /* Footer */
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
            <a href="{{ route('expenses.index') }}" class="nav-tab">
                <i class="fas fa-receipt"></i> Expenses
            </a>
            <a href="{{ route('budget.index') }}" class="nav-tab">
                <i class="fas fa-chart-pie"></i> Budget
            </a>
            <a href="{{ route('settings.index') }}" class="nav-tab active">
                <i class="fas fa-cog"></i> Settings
            </a>
        </div>

        <!-- Header -->
        <header class="header">
            <h1><i class="fas fa-user-cog"></i> User Settings</h1>
            <a href="{{ route('dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </header>

        <div class="main-content">
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- User Info Card -->
            <div class="user-info-card">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-details">
                    <h3>{{ $user->name }}</h3>
                    <p>{{ $user->email }}</p>
                    <p>Member since {{ $user->created_at->format('F Y') }}</p>
                </div>
            </div>

            <!-- Profile Settings -->
            <div class="settings-section">
                <h2 class="section-title">
                    <i class="fas fa-user-edit"></i> Profile Information
                </h2>
                
                <form method="POST" action="{{ route('settings.profile.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control" 
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" 
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Profile
                    </button>
                </form>
            </div>

            <!-- Password Settings -->
            <div class="settings-section">
                <h2 class="section-title">
                    <i class="fas fa-lock"></i> Change Password
                </h2>
                
                <form method="POST" action="{{ route('settings.password.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" 
                                   class="form-control" required>
                            @error('current_password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" id="password" name="password" 
                                   class="form-control" required>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                   class="form-control" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-key"></i> Update Password
                    </button>
                </form>
            </div>

            <!-- Preferences Settings -->
            <div class="settings-section">
                <h2 class="section-title">
                    <i class="fas fa-sliders-h"></i> Preferences
                </h2>
                
                <form method="POST" action="{{ route('settings.preferences.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label>Currency</label>
                        <div class="preference-options">
                            <div class="preference-option">
                                <input type="radio" id="currency_ksh" name="currency" value="KSH" 
                                       {{ old('currency', session('user_preferences.currency', 'KSH')) == 'KSH' ? 'checked' : '' }}>
                                <label for="currency_ksh">
                                    <i class="fas fa-coins"></i> KSH (Kenyan Shilling)
                                </label>
                            </div>
                            <div class="preference-option">
                                <input type="radio" id="currency_usd" name="currency" value="USD" 
                                       {{ old('currency', session('user_preferences.currency', 'KSH')) == 'USD' ? 'checked' : '' }}>
                                <label for="currency_usd">
                                    <i class="fas fa-dollar-sign"></i> USD (US Dollar)
                                </label>
                            </div>
                            <div class="preference-option">
                                <input type="radio" id="currency_eur" name="currency" value="EUR" 
                                       {{ old('currency', session('user_preferences.currency', 'KSH')) == 'EUR' ? 'checked' : '' }}>
                                <label for="currency_eur">
                                    <i class="fas fa-euro-sign"></i> EUR (Euro)
                                </label>
                            </div>
                            <div class="preference-option">
                                <input type="radio" id="currency_gbp" name="currency" value="GBP" 
                                       {{ old('currency', session('user_preferences.currency', 'KSH')) == 'GBP' ? 'checked' : '' }}>
                                <label for="currency_gbp">
                                    <i class="fas fa-pound-sign"></i> GBP (British Pound)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Date Format</label>
                        <div class="preference-options">
                            <div class="preference-option">
                                <input type="radio" id="date_ymd" name="date_format" value="Y-m-d" 
                                       {{ old('date_format', session('user_preferences.date_format', 'Y-m-d')) == 'Y-m-d' ? 'checked' : '' }}>
                                <label for="date_ymd">
                                    <i class="fas fa-calendar"></i> YYYY-MM-DD ({{ date('Y-m-d') }})
                                </label>
                            </div>
                            <div class="preference-option">
                                <input type="radio" id="date_dmy" name="date_format" value="d/m/Y" 
                                       {{ old('date_format', session('user_preferences.date_format', 'Y-m-d')) == 'd/m/Y' ? 'checked' : '' }}>
                                <label for="date_dmy">
                                    <i class="fas fa-calendar-alt"></i> DD/MM/YYYY ({{ date('d/m/Y') }})
                                </label>
                            </div>
                            <div class="preference-option">
                                <input type="radio" id="date_mdy" name="date_format" value="m/d/Y" 
                                       {{ old('date_format', session('user_preferences.date_format', 'Y-m-d')) == 'm/d/Y' ? 'checked' : '' }}>
                                <label for="date_mdy">
                                    <i class="fas fa-calendar-check"></i> MM/DD/YYYY ({{ date('m/d/Y') }})
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="notifications" name="notifications" value="1" 
                                   {{ old('notifications', session('user_preferences.notifications', true)) ? 'checked' : '' }}>
                            <label for="notifications">
                                <i class="fas fa-bell"></i> Enable notifications for task reminders and payment alerts
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Preferences
                    </button>
                </form>
            </div>

            <!-- Employer Management -->            
            <div class="settings-section">
                <h2 class="section-title">
                    <i class="fas fa-building"></i> Employer Management
                </h2>
                
                <!-- Add New Employer Form -->
                <div class="employer-form-section">
                    <h3 class="subsection-title">
                        <i class="fas fa-plus-circle"></i> Add New Employer
                    </h3>
                    
                    <form method="POST" action="{{ route('settings.employers.store') }}" class="employer-form">
                        @csrf
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="employer_name">Employer Name *</label>
                                <input type="text" id="employer_name" name="name" class="form-control" 
                                       value="{{ old('name') }}" placeholder="e.g., MACFLEX, JUJA, MERU" required>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="default_rate">Default Rate per Page (KSH) *</label>
                                <input type="number" id="default_rate" name="default_rate" class="form-control" 
                                       value="{{ old('default_rate') }}" step="0.01" min="0" max="9999.99" 
                                       placeholder="e.g., 3.50" required>
                                @error('default_rate')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="employer_email">Email (Optional)</label>
                                <input type="email" id="employer_email" name="email" class="form-control" 
                                       value="{{ old('email') }}" placeholder="contact@employer.com">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Employer
                        </button>
                    </form>
                </div>

                <!-- Existing Employers List -->
                <div class="employers-list-section">
                    <h3 class="subsection-title">
                        <i class="fas fa-list"></i> Your Employers ({{ $employers->count() }})
                    </h3>
                    
                    @if($employers->count() > 0)
                        <div class="employers-grid">
                            @foreach($employers as $employer)
                                <div class="employer-card {{ !$employer->is_active ? 'inactive' : '' }}">
                                    <div class="employer-header">
                                        <h4>{{ $employer->name }}</h4>
                                        <div class="employer-status">
                                            @if($employer->is_active)
                                                <span class="status-badge active">
                                                    <i class="fas fa-check-circle"></i> Active
                                                </span>
                                            @else
                                                <span class="status-badge inactive">
                                                    <i class="fas fa-pause-circle"></i> Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="employer-details">
                                        @if($employer->email)
                                            <p><i class="fas fa-envelope"></i> {{ $employer->email }}</p>
                                        @endif
                                        @if($employer->default_rate)
                                            <p><i class="fas fa-money-bill"></i> KSH {{ number_format($employer->default_rate, 2) }}/page</p>
                                        @endif
                                    </div>
                                    
                                    <div class="employer-actions">
                                        <button type="button" class="btn btn-secondary btn-sm" 
                                                onclick="editEmployer({{ $employer->id }})">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        
                                        @if($employer->tasks()->count() == 0)
                                            <form method="POST" action="{{ route('settings.employers.destroy', $employer) }}" 
                                                  style="display: inline;" 
                                                  onsubmit="return confirm('Are you sure you want to delete this employer?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted" title="Cannot delete employer with existing tasks">
                                                <i class="fas fa-info-circle"></i> Has {{ $employer->tasks()->count() }} task(s)
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-building fa-3x"></i>
                            <h4>No Employers Added Yet</h4>
                            <p>Add your first employer using the form above to get started with task management.</p>
                        </div>
                    @endif
                </div>
            </div>
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

        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            // Password confirmation validation
            const passwordForm = document.querySelector('form[action="{{ route('settings.password.update') }}"]');
            if (passwordForm) {
                passwordForm.addEventListener('submit', function(e) {
                    const password = document.getElementById('password').value;
                    const confirmation = document.getElementById('password_confirmation').value;
                    
                    if (password !== confirmation) {
                        e.preventDefault();
                        alert('New password and confirmation do not match.');
                        return false;
                    }
                    
                    if (password.length < 8) {
                        e.preventDefault();
                        alert('New password must be at least 8 characters long.');
                        return false;
                    }
                });
            }
        });

        // Employer management functions
        function editEmployer(employerId) {
            // Find employer data
            const employers = @json($employers);
            const employer = employers.find(e => e.id === employerId);
            
            if (!employer) {
                alert('Employer not found');
                return;
            }
            
            // Populate modal form
            document.getElementById('edit_employer_id').value = employer.id;
            document.getElementById('edit_name').value = employer.name || '';
            document.getElementById('edit_contact_person').value = employer.contact_person || '';
            document.getElementById('edit_email').value = employer.email || '';
            document.getElementById('edit_phone').value = employer.phone || '';
            document.getElementById('edit_address').value = employer.address || '';
            document.getElementById('edit_default_rate').value = employer.default_rate || '';
            document.getElementById('edit_is_active').checked = employer.is_active;
            
            // Show modal
            document.getElementById('editEmployerModal').classList.add('show');
        }
        
        function closeEditModal() {
            document.getElementById('editEmployerModal').classList.remove('show');
        }
        
        // Close modal when clicking outside
        document.getElementById('editEmployerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
        
        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeEditModal();
            }
        });
    </script>
    
    <!-- Edit Employer Modal -->
    <div id="editEmployerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-edit"></i> Edit Employer</h3>
                <button type="button" class="close-btn" onclick="closeEditModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form method="POST" action="" id="editEmployerForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_employer_id" name="employer_id">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="edit_name">Employer Name *</label>
                        <input type="text" id="edit_name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_default_rate">Default Rate per Page (KSH) *</label>
                        <input type="number" id="edit_default_rate" name="default_rate" class="form-control" 
                               step="0.01" min="0" max="9999.99" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_email">Email (Optional)</label>
                        <input type="email" id="edit_email" name="email" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="edit_is_active" name="is_active" value="1">
                            <label for="edit_is_active">
                                <i class="fas fa-check-circle"></i> Active Employer
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-actions" style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Employer
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Update form action when editing employer
        function editEmployer(employerId) {
            // Find employer data
            const employers = @json($employers);
            const employer = employers.find(e => e.id === employerId);
            
            if (!employer) {
                alert('Employer not found');
                return;
            }
            
            // Update form action
            const form = document.getElementById('editEmployerForm');
            form.action = `/settings/employers/${employerId}`;
            
            // Populate modal form
            document.getElementById('edit_employer_id').value = employer.id;
            document.getElementById('edit_name').value = employer.name || '';
            document.getElementById('edit_contact_person').value = employer.contact_person || '';
            document.getElementById('edit_email').value = employer.email || '';
            document.getElementById('edit_phone').value = employer.phone || '';
            document.getElementById('edit_address').value = employer.address || '';
            document.getElementById('edit_default_rate').value = employer.default_rate || '';
            document.getElementById('edit_is_active').checked = employer.is_active;
            
            // Show modal
            document.getElementById('editEmployerModal').classList.add('show');
        }
    </script>
</body>
</html>
