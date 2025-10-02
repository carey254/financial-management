<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - OBADIA</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f7fafc; }
        .container { max-width: 500px; margin: 60px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
        h1 { font-size: 1.4rem; color: #2d3748; margin-bottom: 20px; display:flex; align-items:center; gap:10px; }
        .form-group { margin-bottom: 15px; }
        label { display:block; margin-bottom:8px; color:#4a5568; font-weight:600; }
        .form-control { width:100%; padding:12px 14px; border:2px solid #e2e8f0; border-radius:8px; }
        .btn-primary { width:100%; padding:12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color:#fff; border:none; border-radius:8px; font-weight:700; cursor:pointer; }
        .alert { padding:12px; border-radius:8px; margin-bottom:12px; }
        .alert-success { background:#d4edda; color:#155724; border:1px solid #c3e6cb; }
        .alert-danger { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }
        .back { display:block; margin-top:12px; text-align:center; color:#667eea; text-decoration:none; }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-unlock-alt"></i> Forgot your password?</h1>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">@foreach($errors->all() as $e) {{ $e }}<br>@endforeach</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email address</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <button type="submit" class="btn-primary"><i class="fas fa-paper-plane"></i> Send reset link</button>
        </form>

        <a href="{{ route('login') }}" class="back"><i class="fas fa-arrow-left"></i> Back to login</a>
    </div>
</body>
</html>
