<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SecEngine — Professional vulnerability tracking and remediation platform for security teams.">
    <title>SecEngine | Vulnerability Remediation Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --navy-950: #020c1b;
            --navy-900: #0a192f;
            --navy-800: #112240;
            --navy-600: #233554;
            --green-400: #64ffda;
            --green-500: #0aff9d;
            --slate-100: #ccd6f6;
            --slate-300: #8892b0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background-color: var(--navy-950);
            color: var(--slate-100);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        /* Animated grid */
        .grid-bg {
            position: fixed; inset: 0;
            background-image:
                linear-gradient(rgba(100,255,218,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(100,255,218,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridScroll 20s linear infinite;
            z-index: 0;
        }
        @keyframes gridScroll {
            0%   { background-position: 0 0; }
            100% { background-position: 50px 50px; }
        }
        /* Glow orbs */
        .orb {
            position: fixed; border-radius: 50%; filter: blur(80px); z-index: 0; pointer-events: none;
            animation: orbPulse 6s ease-in-out infinite alternate;
        }
        .orb-1 { width: 500px; height: 500px; top: -150px; left: -150px; background: rgba(100,255,218,0.06); }
        .orb-2 { width: 400px; height: 400px; bottom: -100px; right: -100px; background: rgba(0,200,100,0.05); animation-delay: 3s; }
        @keyframes orbPulse {
            from { opacity: 0.5; transform: scale(1); }
            to   { opacity: 1;   transform: scale(1.1); }
        }
        /* Hero card */
        .hero-card {
            position: relative; z-index: 10;
            background: rgba(17, 34, 64, 0.7);
            border: 1px solid rgba(100,255,218,0.15);
            border-radius: 1.25rem;
            padding: 3.5rem 3rem;
            max-width: 560px;
            width: 100%;
            margin: 1rem;
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 24px 80px rgba(0,0,0,0.6), 0 0 60px rgba(100,255,218,0.06);
            animation: fadeInUp 0.6s ease both;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        /* Logo mark */
        .logo-mark {
            display: flex; align-items: center; justify-content: center;
            width: 64px; height: 64px; border-radius: 1rem;
            background: linear-gradient(135deg, rgba(100,255,218,0.15), rgba(10,255,157,0.08));
            border: 1px solid rgba(100,255,218,0.25);
            margin: 0 auto 1.5rem;
            box-shadow: 0 0 30px rgba(100,255,218,0.15);
        }
        .logo-mark i { font-size: 1.8rem; color: var(--green-400); }
        /* Terminal badge */
        .terminal-tag {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.72rem; color: var(--green-400);
            background: rgba(100,255,218,0.08);
            border: 1px solid rgba(100,255,218,0.2);
            border-radius: 0.4rem; padding: 0.25em 0.75em;
            letter-spacing: 1px; text-transform: uppercase;
            display: inline-block; margin-bottom: 1rem;
        }
        h1 {
            font-family: 'JetBrains Mono', monospace;
            font-size: 2.4rem; font-weight: 700;
            color: var(--slate-100); line-height: 1.15; margin-bottom: 0.75rem;
        }
        h1 span { color: var(--green-400); text-shadow: 0 0 20px rgba(100,255,218,0.4); }
        .subtitle {
            color: var(--slate-300); font-size: 0.95rem; line-height: 1.7;
            margin-bottom: 2.5rem;
        }
        /* Buttons */
        .btn-primary-custom {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: linear-gradient(135deg, #0aff9d, #64ffda);
            color: var(--navy-950) !important; font-weight: 700; font-size: 0.92rem;
            border: none; border-radius: 0.6rem; padding: 0.8rem 2rem;
            text-decoration: none; transition: all 0.25s ease;
            box-shadow: 0 4px 20px rgba(100,255,218,0.25);
        }
        .btn-primary-custom:hover {
            box-shadow: 0 8px 30px rgba(100,255,218,0.45);
            transform: translateY(-2px);
        }
        .btn-secondary-custom {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: transparent; color: var(--slate-300) !important;
            border: 1px solid rgba(100,255,218,0.2); border-radius: 0.6rem;
            padding: 0.8rem 2rem; text-decoration: none; font-size: 0.92rem;
            font-weight: 500; transition: all 0.25s ease;
        }
        .btn-secondary-custom:hover {
            border-color: rgba(100,255,218,0.5); color: var(--green-400) !important;
            background: rgba(100,255,218,0.05);
        }
        /* Feature pills */
        .features {
            display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 2rem;
        }
        .feature-pill {
            font-size: 0.75rem; color: var(--slate-300);
            background: rgba(100,255,218,0.05); border: 1px solid rgba(100,255,218,0.1);
            border-radius: 2rem; padding: 0.3em 0.8em;
            display: flex; align-items: center; gap: 0.35rem;
        }
        .feature-pill i { color: var(--green-400); font-size: 0.7rem; }
        /* Divider */
        .divider {
            height: 1px; background: rgba(100,255,218,0.08);
            margin: 2rem 0;
        }
    </style>
</head>
<body>
    <div class="grid-bg"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="hero-card">
        <div class="logo-mark">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <div class="text-center">
            <span class="terminal-tag">v1.0 // ACTIVE</span>
        </div>

        <h1 class="text-center">
            Sec<span>Engine</span>
        </h1>

        <p class="subtitle text-center">
            A professional-grade platform for logging, tracking, and remediating security vulnerabilities across your infrastructure.
        </p>

        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/home') }}" class="btn-primary-custom">
                        <i class="bi bi-grid-1x2-fill"></i> Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary-custom">
                        <i class="bi bi-box-arrow-in-right"></i> Access Engine
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-secondary-custom">
                            <i class="bi bi-person-plus"></i> Register
                        </a>
                    @endif
                @endauth
            @endif
        </div>

        <div class="divider"></div>

        <div class="features justify-content-center">
            <span class="feature-pill"><i class="bi bi-circle-fill"></i> Real-time Tracking</span>
            <span class="feature-pill"><i class="bi bi-circle-fill"></i> Severity Classification</span>
            <span class="feature-pill"><i class="bi bi-circle-fill"></i> PDF & CSV Export</span>
            <span class="feature-pill"><i class="bi bi-circle-fill"></i> Proof of Concept</span>
            <span class="feature-pill"><i class="bi bi-circle-fill"></i> Analytics Dashboard</span>
        </div>
    </div>

</body>
</html>
