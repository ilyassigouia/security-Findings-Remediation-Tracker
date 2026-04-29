<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="SecEngine — Professional vulnerability tracking and remediation platform">

    <title>{{ config('app.name', 'SecEngine') }} | Security Findings Tracker</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Scripts / Styles via Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">

    <!-- ── Navigation ── -->
    <nav class="navbar navbar-expand-md navbar-dark">
        <div class="container-fluid px-4">

            <!-- Brand -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/home') }}">
                <i class="bi bi-shield-lock-fill" style="color: var(--green-400); font-size:1.1rem;"></i>
                <span>SEC<span style="color:var(--slate-300); font-weight:300;">ENGINE</span></span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <!-- Left links -->
                <ul class="navbar-nav me-auto ms-3">
                    @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'text-green' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-grid-1x2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('findings.create') ? 'text-green' : '' }}" href="{{ route('findings.create') }}">
                            <i class="bi bi-plus-circle me-1"></i> New Finding
                        </a>
                    </li>
                    @endauth
                </ul>

                <!-- Right side -->
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <button class="btn-theme-toggle" onclick="toggleDarkMode()" title="Toggle theme">
                            <i class="bi bi-moon-stars" id="theme-icon"></i>
                        </button>
                    </li>

                    @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="btn-green d-flex align-items-center gap-1 text-decoration-none px-3 py-1" style="border-radius:0.5rem; font-size:0.85rem; font-weight:700;" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Register
                            </a>
                        </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span style="background: rgba(var(--green-400-rgb),0.1); border:1px solid rgba(var(--green-400-rgb),0.2); border-radius:0.5rem; padding:0.25rem 0.75rem; font-size:0.84rem; color:var(--green-400);">
                                    <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i>{{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- ── Page Content ── -->
    <main>
        @yield('content')
    </main>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Theme initialisation
    (function() {
        const saved = localStorage.getItem('sec-theme');
        if (saved === 'light') {
            document.documentElement.setAttribute('data-bs-theme', 'light');
        }
        updateIcon();
    })();

    function updateIcon() {
        const icon = document.getElementById('theme-icon');
        if (!icon) return;
        const isDark = document.documentElement.getAttribute('data-bs-theme') !== 'light';
        icon.className = isDark ? 'bi bi-sun' : 'bi bi-moon-stars';
    }

    function toggleDarkMode() {
        const html = document.documentElement;
        const isDark = html.getAttribute('data-bs-theme') !== 'light';
        html.setAttribute('data-bs-theme', isDark ? 'light' : 'dark');
        localStorage.setItem('sec-theme', isDark ? 'light' : 'dark');
        updateIcon();
    }
</script>

</body>
</html>
