{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mihi Photography</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> {{-- ඔබේ custom CSS --}}
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* Background Image for Login Form */
            background-image: url('{{ asset("images/65ff0064f808268968626491_DJI_0594.jpg") }}'); /* ඔබේ image path එක මෙතන දමන්න */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #333;
        }
        .login-container {
            background-color: rgba(255, 255, 255, 0.9); /* අඩක් විනිවිද පෙනෙන සුදු පසුබිමක් */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 30px;
            color: #333;
            font-size: 2em;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box; /* Padding borders වලට ඇතුළත් කිරීමට */
        }
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .login-button {
            background-color: #007bff;
            color: white;
            padding: 15px 25px;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        .login-button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.9em;
            margin-bottom: 15px; /* Adjust margin */
            text-align: left;
            list-style-type: none; /* Remove bullet points */
            padding: 0;
        }
        .success-message {
            color: #28a745;
            font-size: 1em;
            margin-bottom: 20px;
            font-weight: bold;
        }
        /* Optional: Register link */
        .register-link {
            margin-top: 20px;
            font-size: 0.9em;
            color: #555;
        }
        .register-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>

        {{-- Success Message Display (redirect from login or register) --}}
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message Display (from AuthController validation) --}}
        @if ($errors->any())
            <ul class="error-message">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf {{-- CSRF protection --}}

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="login-button">Login</button>
        </form>

        @if (Route::has('register'))
            <div class="register-link">
                Don't have an account? <a href="{{ route('register') }}">Register here</a>
            </div>
        @endif
    </div>
</body>
</html>