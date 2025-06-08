@extends('layouts.app')

@section('content')
{{-- Kontainer Utama Halaman --}}
<div class="container-fluid px-0">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            
            {{-- Header Halaman --}}
            <div class="header">
                <a href="{{ route('profile.show', $user->id) }}" class="btn btn-light btn-sm btn-back">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Profile
                </a>
                <div class="header-title">
                    <h2 class="mb-0"><i class="fas fa-edit me-1 me-md-3"></i>Edit Profile</h2>
                </div>
            </div>

            {{-- Kartu Formulir Edit Profil --}}
            <div class="card profile-edit-card">
                <div class="card-body p-4">
                    {{-- Formulir Utama --}}
                    <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        {{-- Bagian Unggah Foto Profil --}}
                        <div class="image-upload-section">
                            <div class="position-relative d-inline-block mb-3">
                                <img id="profile-preview" src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/120' }}" class="profile-picture">
                                {{-- Ikon Ganti Foto --}}
                                <div class="camera-icon-overlay" onclick="document.getElementById('profile_image').click();">
                                    <i class="fas fa-camera text-white"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="file" class="d-none @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(this)">
                                <label for="profile_image" class="btn btn-outline-primary btn-sm btn-change-photo">
                                    <i class="fas fa-upload me-2"></i>
                                    Change Photo
                                </label>
                                {{-- Pesan Error Validasi Gambar --}}
                                @error('profile_image')
                                <div class="invalid-feedback d-block mt-2">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <p class="image-help-text">JPG, PNG or GIF. Max size 2MB</p>
                        </div>

                        {{-- Input Fields: Nama & Username --}}
                        <div class="row">
                            {{-- Input Nama Lengkap --}}
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-user me-2 text-muted"></i>
                                    Full Name
                                </label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required placeholder="Enter your full name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            {{-- Input Username --}}
                            <div class="col-md-6 mb-4">
                                <label for="username" class="form-label fw-semibold">
                                    <i class="fas fa-at me-2 text-muted"></i>
                                    Username
                                </label>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', $user->username) }}" required placeholder="Choose a unique username">
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Input Field Bio --}}
                        <div class="mb-4">
                            <label for="bio" class="form-label fw-semibold">
                                <i class="fas fa-quote-left me-2 text-muted"></i>
                                Bio
                            </label>
                            <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" name="bio" rows="4" placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                            <div class="form-text bio-help-text">
                                Write a short bio to tell people about yourself
                            </div>
                            @error('bio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        {{-- Tombol Aksi Formulir --}}
                        <div class="form-actions">
                            <a href="{{ route('profile.show', $user->id) }}" class="btn btn-light btn-cancel">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-submit">
                                <i class="fas fa-save me-2"></i>
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Skrip Kustom Halaman --}}
<script>
    // Menampilkan pratinjau gambar yang dipilih oleh pengguna.
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Menambahkan efek visual 'focus' pada semua input form saat DOM dimuat.
    document.addEventListener('DOMContentLoaded', function() {
        const formControls = document.querySelectorAll('.form-control');
        formControls.forEach(control => {
            control.addEventListener('focus', function() {
                this.style.borderColor = 'var(--primary-color)';
                this.style.boxShadow = '0 0 0 0.1rem rgba(0, 123, 255, 0.25)';
            });

            control.addEventListener('blur', function() {
                this.style.borderColor = 'var(--border-color)';
                this.style.boxShadow = 'none';
            });
        });
    });
</script>

{{-- Gaya Kustom Halaman --}}
<style>
    /* Header Halaman */
    .header {
        position: relative;
        margin-bottom: 1rem;
        margin-top: 0.5rem;
    }
    .btn-back {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        border-radius: 50px;
        padding: 0.5rem 1rem;
        z-index: 1;
        display: flex;
        align-items: center;
    }
    .header-title {
        text-align: end;
        margin-right: 18px;
    }
    .header-title h2 {
        font-weight: 600;
        font-size: 20px;
        color: var(--text-primary);
    }

    /* Kartu & Formulir */
    .profile-edit-card {
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        background: var(--card-background);
        box-shadow: var(--shadow-sm);
    }
    .form-label {
        color: var(--text-primary);
        margin-bottom: 0.75rem;
    }
    .form-control {
        border-radius: 12px;
        border: 1px solid var(--border-color);
        padding: 0.875rem 1rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.1rem rgba(0, 123, 255, 0.25);
    }
    textarea.form-control {
        resize: vertical;
    }
    .bio-help-text {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
    
    /* Bagian Unggah Gambar */
    .image-upload-section {
        text-align: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }
    .profile-picture {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 3px solid var(--border-color) !important;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    .profile-picture:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }
    .camera-icon-overlay {
        position: absolute;
        bottom: 0;
        right: 0;
        background-color: var(--primary-color);
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .camera-icon-overlay i {
        font-size: 0.9rem;
    }
    .btn-change-photo {
        border-radius: 50px;
    }
    .image-help-text {
        font-size: 0.85rem;
        color: var(--text-secondary);
        margin-bottom: 0;
    }

    /* Tombol Aksi */
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }
    .btn-cancel {
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
    }
    .btn-submit {
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        background: var(--primary-color);
        border: none;
    }
    .btn-submit:hover {
        background-color: #0056b3 !important;
        box-shadow: var(--shadow-medium) !important;
        color: white;
    }
    .btn-light:hover {
        background-color: var(--hover-color);
        border-color: var(--border-color);
    }
    
    /* Gaya Responsif */
    @media (max-width: 991.98px) {
        .header, .profile-edit-card {
            margin-left: 1.5rem;
            margin-right: 1.5rem;
        }
    }
    @media (max-width: 576px) {
        .header {
            margin: 0;
        }
        .profile-edit-card {
            border-radius: 0 !important;
            margin-left: 0;
            margin-right: 0;
            margin-top: 0.5rem
        }
    }
</style>
@endsection