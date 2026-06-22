<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | {{ config('app.name', 'Laravel') }}</title>
    <style>
        body {
            margin: 0;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f8fafc;
            color: #111827;
        }
        .page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .card {
            max-width: 420px;
            width: 100%;
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
            padding: 2rem;
        }
        .logo {
            display: inline-block;
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.03em;
        }
        .heading {
            margin: 0 0 0.75rem;
            font-size: 1.75rem;
            line-height: 1.1;
        }
        .text-muted {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
            color: #374151;
        }
        input {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 0.75rem;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            color: #111827;
            background: #f9fafb;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
            background: #ffffff;
        }
        .button {
            width: 100%;
            border: none;
            border-radius: 0.75rem;
            background: #2563eb;
            color: #ffffff;
            padding: 0.95rem 1rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.75rem;
        }
        .button:hover {
            background: #1d4ed8;
        }
        .error-box {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 0.9rem 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1rem;
        }
        .bottom-note {
            margin-top: 1rem;
            font-size: 0.95rem;
            color: #6b7280;
        }
        .bottom-note a {
            color: #2563eb;
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
            <h1 class="heading">Create your account</h1>
            <p class="text-muted">Sign up to access the dashboard and manage your data.</p>

            @if ($errors->any())
                <div class="error-box">
                    <strong>Something went wrong.</strong>
                    <ul style="margin:0.5rem 0 0 1rem; padding:0; list-style: disc;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('doregister') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
                </div>

                <button type="submit" class="button">Register as Admin</button>
            </form>

            <p class="bottom-note">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
        </section>
    </div>
</body>
</html>
