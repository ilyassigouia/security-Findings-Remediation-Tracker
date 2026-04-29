@extends('layouts.app')

@section('content')
<style>
    body { background-color: var(--navy-950); }
    .auth-card {
        background: rgba(var(--navy-800-rgb), 0.7) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(var(--green-400-rgb), 0.2) !important;
        box-shadow: 0 24px 80px rgba(var(--navy-950-rgb), 0.6), 0 0 40px rgba(var(--green-400-rgb), 0.05) !important;
        border-radius: 1rem !important;
        overflow: hidden;
    }
    .auth-card .card-header {
        background: rgba(var(--navy-950-rgb), 0.6) !important;
        border-bottom: 1px solid rgba(var(--green-400-rgb), 0.1) !important;
        font-family: 'JetBrains Mono', monospace;
        color: var(--green-400) !important;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 700;
        padding: 1.5rem;
    }
    .auth-logo {
        font-size: 2.5rem;
        color: var(--green-400);
        margin-bottom: 1rem;
        text-shadow: 0 0 20px rgba(var(--green-400-rgb), 0.5);
    }
    .grid-bg-auth {
        position: fixed; inset: 0;
        background-image:
            linear-gradient(rgba(var(--green-400-rgb),0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(var(--green-400-rgb),0.03) 1px, transparent 1px);
        background-size: 50px 50px;
        z-index: -1;
        pointer-events: none;
    }
</style>


<div class="grid-bg-auth"></div>

<div class="container mt-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <i class="bi bi-person-badge-fill auth-logo"></i>
                <h3 class="text-white font-mono fw-bold">New Operative</h3>
            </div>

            <div class="card auth-card glow-border">
                <div class="card-header text-center fs-5">
                    <i class="bi bi-terminal"></i> {{ __('Register Access') }}
                </div>

                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label"><i class="bi bi-person me-1"></i> {{ __('Alias / Name') }}</label>
                            <input id="name" type="text" class="form-control font-mono @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="operative_alpha">
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label"><i class="bi bi-envelope me-1"></i> {{ __('Comm Channel (Email)') }}</label>
                            <input id="email" type="email" class="form-control font-mono @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="operative@system.local">
                            @error('email')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label"><i class="bi bi-key me-1"></i> {{ __('Encryption Key (Password)') }}</label>
                            <input id="password" type="password" class="form-control font-mono @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="••••••••">
                            @error('password')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label"><i class="bi bi-key-fill me-1"></i> {{ __('Verify Key') }}</label>
                            <input id="password-confirm" type="password" class="form-control font-mono" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn-green py-3 fs-6 d-flex justify-content-center align-items-center gap-2">
                                <i class="bi bi-person-check-fill"></i> {{ __('Create Profile') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
