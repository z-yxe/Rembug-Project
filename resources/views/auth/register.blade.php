@extends('layouts.app')

@section('content')
<div class="container py-6">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            <div class="register-card" style="background: var(--card-background); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 2rem 2.5rem; box-shadow: var(--shadow-medium);">
                
                <div class="text-center mb-4">
                    <a class="navbar-brand" href="{{ url('/') }}" style="font-weight: 700; font-size: 2.4rem; text-decoration: none; letter-spacing: -0.02em; display: block;">
                        <span class="brand-text-lobster">Rembug</span>
                    </a>
                    <p class="mt-2" style="color: var(--text-secondary); font-size: 1rem;">Buat akun baru untuk bergabung.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label" style="font-weight: 500; color: var(--text-primary); font-size: 0.85rem; margin-bottom: 0.4rem;">{{ __('Nama') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Masukkan nama Anda"
                               style="border-radius: 8px; border-color: var(--border-color); background-color: var(--card-background); color: var(--text-primary); padding: 0.65rem 1rem; box-shadow: var(--shadow-light); font-size: 0.9rem;">
                        @error('name')
                            <span class="invalid-feedback" role="alert" style="font-size: 0.8rem;"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label" style="font-weight: 500; color: var(--text-primary); font-size: 0.85rem; margin-bottom: 0.4rem;">{{ __('Alamat Email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="contoh@email.com"
                               style="border-radius: 8px; border-color: var(--border-color); background-color: var(--card-background); color: var(--text-primary); padding: 0.65rem 1rem; box-shadow: var(--shadow-light); font-size: 0.9rem;">
                        @error('email')
                            <span class="invalid-feedback" role="alert" style="font-size: 0.8rem;"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label" style="font-weight: 500; color: var(--text-primary); font-size: 0.85rem; margin-bottom: 0.4rem;">{{ __('Kata Sandi') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Buat kata sandi (min. 8 karakter)"
                               style="border-radius: 8px; border-color: var(--border-color); background-color: var(--card-background); color: var(--text-primary); padding: 0.65rem 1rem; box-shadow: var(--shadow-light); font-size: 0.9rem;">
                        @error('password')
                            <span class="invalid-feedback" role="alert" style="font-size: 0.8rem;"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label" style="font-weight: 500; color: var(--text-primary); font-size: 0.85rem; margin-bottom: 0.4rem;">{{ __('Konfirmasi Kata Sandi') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi"
                               style="border-radius: 8px; border-color: var(--border-color); background-color: var(--card-background); color: var(--text-primary); padding: 0.65rem 1rem; box-shadow: var(--shadow-light); font-size: 0.9rem;">
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary-themed py-2"
                                style="background-color: var(--primary-color); color: white; font-weight: 600; font-size: 0.95rem; border-radius: 8px; border: none; transition: all 0.2s ease; box-shadow: var(--shadow-light);">
                            {{ __('Daftar') }}
                        </button>
                    </div>
                    
                    @if (Route::has('login'))
                    <p class="text-center mb-0" style="font-size: 0.85rem; color: var(--text-secondary);">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">Masuk di sini</a>
                    </p>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-primary-themed:hover {
        background-color: #0056b3 !important;
        transform: translateY(-1px);
        box-shadow: var(--shadow-medium) !important;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-rgb, 0, 123, 255), 0.25);
        background-color: var(--card-background); 
    }
</style>
@endsection