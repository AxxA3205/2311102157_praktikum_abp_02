<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Inventori Toko') }} — @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --blue-50:  #eff6ff;
            --blue-100: #dbeafe;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
            --blue-800: #1e40af;
            --gray-50:  #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --green-100:#dcfce7;
            --green-600:#16a34a;
            --red-100:  #fee2e2;
            --red-600:  #dc2626;
            --yellow-100:#fef9c3;
            --yellow-700:#a16207;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', system-ui, sans-serif; background: var(--gray-50); color: var(--gray-800); min-height: 100vh; }
        .navbar {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 0 2rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--blue-700);
            text-decoration: none;
        }
        .navbar-brand .logo-icon {
            width: 36px; height: 36px;
            background: var(--blue-600);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 1.1rem;
        }
        .navbar-right { display: flex; align-items: center; gap: 1.5rem; }
        .navbar-user { font-size: 0.875rem; color: var(--gray-500); }
        .navbar-user strong { color: var(--gray-800); }
        .btn-logout {
            font-size: 0.8rem;
            color: var(--gray-500);
            background: none;
            border: 1px solid var(--gray-200);
            padding: 6px 14px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-logout:hover { background: var(--red-100); color: var(--red-600); border-color: var(--red-600); }
        .main-wrapper { max-width: 1280px; margin: 0 auto; padding: 2rem 1.5rem; }
        .page-header { margin-bottom: 1.75rem; }
        .page-header h1 { font-size: 1.5rem; font-weight: 700; color: var(--gray-900); }
        .page-header p { color: var(--gray-500); font-size: 0.9rem; margin-top: 2px; }
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: var(--green-100); color: var(--green-600); }
        .alert-danger  { background: var(--red-100); color: var(--red-600); }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('products.index') }}" class="navbar-brand">
            <div class="logo-icon">🏪</div>
            <span>Toko Pak Cokomi<br><small style="font-weight:400;font-size:0.7rem;color:var(--blue-500)">& Mas Wowo</small></span>
        </a>
        <div class="navbar-right">
            <div class="navbar-user">Halo, <strong>{{ Auth::user()->name }}</strong></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Keluar</button>
            </form>
        </div>
    </nav>

    <div class="main-wrapper">
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">❌ {{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>