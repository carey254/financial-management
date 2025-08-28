<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OBADIA - Freelance Task Manager</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .landing-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            overflow: hidden;
            width: 900px;
            max-width: 95vw;
            min-height: 600px;
            display: flex;
        }

        .brand-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .brand-logo {
            font-size: 4rem;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #fff, #f0f8ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .brand-tagline {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .brand-features {
            list-style: none;
            text-align: left;
        }

        .brand-features li {
            margin: 15px 0;
            display: flex;
            align-items: center;
            font-size: 1rem;
            opacity: 0.9;
        }

        .brand-features i {
            margin-right: 15px;
            width: 20px;
            color: #ffd700;
        }

        .auth-section {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-tabs {
            display: flex;
            margin-bottom: 30px;
            border-radius: 10px;
            background: #f8f9fa;
            padding: 5px;
        }

        .auth-tab {
            flex: 1;
            padding: 15px;
            text-align: center;
            border: none;
            background: transparent;
            color: #6c757d;
            font-weight: 600;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .auth-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .auth-form {
            display: none;
        }

        .auth-form.active {
            display: block;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #495057;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
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

        .btn-primary {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me input {
            margin-right: 10px;
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

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .welcome-message {
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome-message h2 {
            color: #495057;
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .welcome-message p {
            color: #6c757d;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .landing-container {
                flex-direction: column;
                width: 95vw;
                min-height: auto;
            }

            .brand-section {
                padding: 40px 30px;
            }

            .brand-logo {
                font-size: 3rem;
            }

            .auth-section {
                padding: 40px 30px;
            }
        }

        /* Footer Styles */
        .landing-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.9);
            padding: 15px 20px;
            text-align: center;
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .landing-footer .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #4a5568;
            font-size: 0.85rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .landing-footer .footer-links a {
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .landing-footer .footer-links a:hover {
            color: #764ba2;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            body {
                padding: 10px;
                align-items: flex-start;
                min-height: 100vh;
            }

            .landing-container {
                flex-direction: column;
                width: 100%;
                min-height: auto;
                margin-bottom: 80px; /* Space for footer */
            }

            .brand-section {
                padding: 30px 20px;
                min-height: 200px;
            }

            .brand-logo {
                font-size: 2.5rem;
                margin-bottom: 15px;
            }

            .brand-tagline {
                font-size: 1rem;
                margin-bottom: 20px;
            }

            .brand-features {
                display: none; /* Hide on mobile to save space */
            }

            .auth-section {
                padding: 30px 20px 40px 20px; /* Extra bottom padding */
            }

            .auth-tabs {
                margin-bottom: 20px;
            }

            .auth-tab {
                font-size: 0.9rem;
                padding: 12px 16px;
            }

            .welcome-message h2 {
                font-size: 1.5rem;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .btn-primary {
                padding: 15px 20px;
                font-size: 1rem;
                margin-bottom: 20px; /* Extra space before footer */
            }

            .landing-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                padding: 15px 20px;
                z-index: 1000;
            }

            .landing-footer .footer-content {
                flex-direction: column;
                gap: 8px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .landing-container {
                margin-bottom: 100px; /* More space for footer on very small screens */
            }

            .auth-section {
                padding: 20px 15px 50px 15px; /* Even more bottom padding */
            }

            .brand-logo {
                font-size: 2rem;
            }

            .welcome-message h2 {
                font-size: 1.3rem;
            }

            .btn-primary {
                margin-bottom: 30px; /* Extra space on very small screens */
            }
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <!-- Brand Section -->
        <div class="brand-section">
            <div class="brand-logo">
                <i class="fas fa-briefcase"></i>
                OBADIA
            </div>
            <div class="brand-tagline">
                Professional Freelance Management Platform
            </div>
        </div>

        <!-- Authentication Section -->
        <div class="auth-section">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <!-- Auth Tabs -->
            <div class="auth-tabs">
                <button class="auth-tab active" onclick="showLogin()">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
                <button class="auth-tab" onclick="showRegister()">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </div>

            <!-- Login Form -->
            <div id="loginForm" class="auth-form active">
                <div class="welcome-message">
                    <h2>OBADIA Welcome Back!</h2>
                    <p>Sign in to your account</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="login_email">Email Address</label>
                        <input type="email" id="login_email" name="email" class="form-control" 
                               value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="login_password">Password</label>
                        <input type="password" id="login_password" name="password" class="form-control" required>
                    </div>

                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Sign In to OBADIA
                    </button>
                </form>
            </div>

            <!-- Register Form -->
            <div id="registerForm" class="auth-form">
                <div class="welcome-message">
                    <h2>Welcome to OBADIA!</h2>
                    <p>Create your account to get started</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="register_name">Full Name</label>
                        <input type="text" id="register_name" name="name" class="form-control" 
                               value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="register_email">Email Address</label>
                        <input type="email" id="register_email" name="email" class="form-control" 
                               value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="register_password">Password</label>
                        <input type="password" id="register_password" name="password" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="register_password_confirmation">Confirm Password</label>
                        <input type="password" id="register_password_confirmation" 
                               name="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn-primary">
                        <i class="fas fa-user-plus"></i> Create OBADIA Account
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="landing-footer">
        <div class="footer-content">
            <p>&copy; 2025 User | All Rights Reserved</p>
            <div class="footer-links">
                <a href="#">Help</a> | 
                <a href="#">Support</a> | 
                <a href="#">Version 1.0</a>
            </div>
        </div>
    </footer>

    <script>
        function showLogin() {
            document.getElementById('loginForm').classList.add('active');
            document.getElementById('registerForm').classList.remove('active');
            
            document.querySelectorAll('.auth-tab')[0].classList.add('active');
            document.querySelectorAll('.auth-tab')[1].classList.remove('active');
        }

        function showRegister() {
            document.getElementById('registerForm').classList.add('active');
            document.getElementById('loginForm').classList.remove('active');
            
            document.querySelectorAll('.auth-tab')[1].classList.add('active');
            document.querySelectorAll('.auth-tab')[0].classList.remove('active');
        }

        // Auto-focus on form switch
        document.addEventListener('DOMContentLoaded', function() {
            const loginTab = document.querySelectorAll('.auth-tab')[0];
            const registerTab = document.querySelectorAll('.auth-tab')[1];
            
            loginTab.addEventListener('click', function() {
                setTimeout(() => {
                    document.getElementById('login_email').focus();
                }, 100);
            });
            
            registerTab.addEventListener('click', function() {
                setTimeout(() => {
                    document.getElementById('register_name').focus();
                }, 100);
            });
        });
    </script>
</body>
</html>
