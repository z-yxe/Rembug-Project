@extends('layouts.app')

@section('content')
{{-- Kontainer Utama Halaman --}}
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            {{-- Kartu Registrasi --}}
            <div class="register-card">
                
                {{-- Header Kartu --}}
                <div class="register-header">
                    <a class="navbar-brand register-brand" href="{{ url('/') }}">
                        <span class="brand-text-lobster">Rembug</span>
                    </a>
                    <p class="register-subtitle">Buat akun baru untuk bergabung.</p>
                </div>

                {{-- Formulir Registrasi --}}
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Input Field Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label form-label-custom">{{ __('Nama') }}</label>
                        <input id="name" type="text" class="form-control form-control-custom @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Masukkan nama Anda">
                        @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- Input Field Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label form-label-custom">{{ __('Alamat Email') }}</label>
                        <input id="email" type="email" class="form-control form-control-custom @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="contoh@email.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- Input Field Kata Sandi --}}
                    <div class="mb-3">
                        <label for="password" class="form-label form-label-custom">{{ __('Kata Sandi') }}</label>
                        <input id="password" type="password" class="form-control form-control-custom @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Buat kata sandi (min. 8 karakter)">
                        @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    {{-- Input Field Konfirmasi Kata Sandi --}}
                    <div class="mb-4">
                        <label for="password-confirm" class="form-label form-label-custom">{{ __('Konfirmasi Kata Sandi') }}</label>
                        <input id="password-confirm" type="password" class="form-control form-control-custom" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi">
                    </div>

                    {{-- Tombol Submit Registrasi --}}
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-register">
                            {{ __('Daftar') }}
                        </button>
                    </div>
                    
                    {{-- Tautan ke Halaman Login --}}
                    @if (Route::has('login'))
                    <p class="text-center login-prompt">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="link-login">Masuk di sini</a>
                    </p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Gaya Kustom Halaman Registrasi --}}
<style>
    /* Tata Letak & Kartu */
    .register-card {
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
    .register-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .register-brand {
        font-weight: 700;
        font-size: 2.4rem;
        text-decoration: none;
        letter-spacing: -0.02em;
        display: block;
    }
    .register-subtitle {
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
    .btn-register {
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
    .btn-register:hover {
        background-color: #0056b3 !important; 
        transform: translateY(-1px);
        box-shadow: var(--shadow-medium) !important;
    }
    .login-prompt {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 0;
    }
    .link-login {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }
</style>
@endsection