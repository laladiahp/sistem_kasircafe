<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | {{ config('app.name', 'Laravel') }}</title>
    <style>
        body {
            margin: 0;
            font-family: "Inter", "Segoe UI", system-ui, -apple-system, sans-serif;
            background: #FDFBF7; /* Soft warm beige */
            color: #3E2723; /* Very dark brown */
            background-image: radial-gradient(#EFEBE0 1px, transparent 1px);
            background-size: 20px 20px;
        }
        .page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .card {
            max-width: 400px;
            width: 100%;
            background: #ffffff;
            border-radius: 1.25rem;
            box-shadow: 0 10px 40px rgba(94, 69, 53, 0.08);
            padding: 2.5rem 2.25rem;
            border: 1px solid #F5F0E6;
            box-sizing: border-box;
        }
        .logo {
            display: inline-block;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #5D4037; /* Rich brown */
        }
        .heading {
            margin: 0 0 0.5rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: #3E2723;
        }
        .text-muted {
            color: #8D6E63;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #5D4037;
        }
        input {
            width: 100%;
            border: 1.5px solid #EFEBE0;
            border-radius: 0.75rem;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            color: #3E2723;
            background: #FDFBF7;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }
        input:focus {
            outline: none;
            border-color: #8D6E63;
            box-shadow: 0 0 0 4px rgba(141, 110, 99, 0.15);
            background: #ffffff;
        }
        .button {
            width: 100%;
            border: none;
            border-radius: 0.75rem;
            background: #6D4C41;
            color: #ffffff;
            padding: 1rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 1rem;
            transition: background 0.2s ease, transform 0.1s ease;
        }
        .button:hover {
            background: #5D4037;
        }
        .button:active {
            transform: scale(0.98);
        }
        .error-box {
            background: #FBE9E7;
            color: #D84315;
            border: 1px solid #FFCCBC;
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        .bottom-note {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            color: #8D6E63;
        }
        .bottom-note a {
            color: #6D4C41;
            font-weight: 600;
            text-decoration: none;
        }
        .bottom-note a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="page">
        <section class="card">
            <div class="logo">{{ config('app.name', 'Laravel') }}</div>
            <h1 class="heading">Sign in to your account</h1>
            <p class="text-muted">Enter your email and password to continue.</p>
            
            @if ($errors->any())
                <div class="error-box">
                    <strong>Login failed.</strong>
                    <ul style="margin:0.5rem 0 0 1rem; padding:0; list-style: disc;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" required autofocus autocomplete="email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password">
                </div>

                <div class="form-group" style="display:flex; align-items:center; gap:1rem;">
                    <label style="display:flex; align-items:center; gap:0.5rem; font-size:0.9rem; color:#374151;">
                        <input type="checkbox" name="remember" style="width:1rem;height:1rem; margin:0;">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="button">Log in</button>
                <p class="bottom-note">Don't have account? <a href="{{ route('register') }}">Register now</a></p>
            </form>
        </section>
    </div>
</body>
</html>
