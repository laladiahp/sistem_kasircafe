<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Pesan Makanan')</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css')}}">
    <style>
        body {
            background: #f8f9fa;
        }
        .customer-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 1rem;
        }
        .customer-header {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            text-align: center;
        }
        .customer-header h2 {
            margin: 0;
            color: #333;
        }
        .customer-header p {
            margin: 0.5rem 0 0;
            color: #666;
            font-size: 0.95rem;
        }
        .customer-footer {
            text-align: center;
            padding: 2rem 1rem;
            color: #999;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="customer-container">
        @if (Route::has('login') && Auth::guest())
            <div class="customer-header">
                <h2>🍽️ Pesan Makanan</h2>
                <p>Pesanan disiapkan khusus untuk Anda</p>
            </div>
        @endif

        @yield('content')

        <div class="customer-footer">
            <small>&copy; 2026 Sistem Kasir Café. Terima kasih telah memesan.</small>
        </div>
    </div>

    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{ asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{ asset('assets/js/template.js')}}"></script>
    <script src="{{ asset('assets/js/settings.js')}}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js')}}"></script>
    @stack('scripts')
</body>
</html>
