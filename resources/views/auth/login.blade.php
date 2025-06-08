@extends('layouts.app')

@section('content')
{{-- Kontainer Utama Halaman --}}
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            {{-- Kartu Login --}}
            <div class="login-card">
                
                {{-- Header Kartu --}}
                <div class="login-header">
                    <a class="navbar-brand login-brand" href="{{ url('/') }}">
                        <span class="brand-text-lobster">Rembug</span>
                    </a>
                    <p class="login-subtitle">Selamat datang kembali!</p>
                </div>

                {{-- Formulir Login --}}
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Input Field Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label form-label-custom">{{ __('Alamat Email') }}</label>
                        <input id="email" type="email" class="form-control form-control-custom @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="contoh@email.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- Input Field Kata Sandi --}}
                    <div class="mb-3">
                        <label for="password" class="form-label form-label-custom">{{ __('Kata Sandi') }}</label>
                        <input id="password" type="password" class="form-control form-control-custom @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi Anda">
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- Tautan Lupa Kata Sandi --}}
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        @if (Route::has('password.request'))
                            <a class="link-forgot-password" href="{{ route('password.request') }}">
                                {{ __('Lupa Kata Sandi?') }}
                            </a>
                        @endif
                    </div>

                    {{-- Tombol Submit Login --}}
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-login">
                            {{ __('Login') }}
                        </button>
                    </div>
                    
                    {{-- Tautan ke Halaman Registrasi --}}
                    @if (Route::has('register'))
                    <p class="text-center register-prompt">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="link-register">Daftar di sini</a>
                    </p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Gaya Kustom Halaman Login --}}
<style>
    /* Tata Letak & Kartu */
    .login-card {
        background: var(--card-background);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        padding: 2rem 2.5rem;
        box-shadow: var(--shadow-medium);
    }
    .py-6 {
        padding-top: 4rem;
        padding-bottom: 4rem;
    }

    /* Header & Merek */
    .login-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .login-brand {
        font-weight: 700;
        font-size: 2.4rem;
        text-decoration: none;
        letter-spacing: -0.02em;
        display: block;
    }
    .login-subtitle {
        margin-top: 0.5rem;
        color: var(--text-secondary);
        font-size: 1rem;
    }

    /* Formulir & Input */
    .form-label-custom {
        font-weight: 500;
        color: var(--text-primary);
        font-size: 0.85rem;
        margin-bottom: 0.4rem;
    }
    .form-control-custom {
        border-radius: 8px;
        border-color: var(--border-color);
        background-color: var(--card-background);
        color: var(--text-primary);
        padding: 0.65rem 1rem;
        box-shadow: var(--shadow-light);
        font-size: 0.9rem;
    }
    .form-control-custom:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-rgb, 0, 123, 255), 0.25);
        background-color: var(--card-background); 
    }
    .invalid-feedback {
        font-size: 0.8rem;
    }
    
    /* Tombol & Tautan */
    .btn-login {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 8px;
        border: none;
        transition: all 0.2s ease;
        box-shadow: var(--shadow-light);
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }
    .btn-login:hover {
        background-color: #0056b3 !important; 
        transform: translateY(-1px);
        box-shadow: var(--shadow-medium) !important;
    }
    .link-forgot-password {
        font-size: 0.85rem;
        color: var(--primary-color);
        text-decoration: none;
    }
    .register-prompt {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 0;
    }
    .link-register {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }
</style>
@endsection