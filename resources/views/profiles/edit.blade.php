@extends('layouts.app')

@section('content')
<div class="container-fluid px-0">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <div class="mb-4" style="position: relative;">
                <a href="{{ route('profile.show', $user->id) }}" class="btn btn-light btn-sm d-flex align-items-center" style="position: absolute; top: 50%; left: 0; transform: translateY(-50%); border-radius: 50px; padding: 0.5rem 1rem; z-index: 1;">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Profile
                </a>
                <div class="text-center">
                    <h2 class="mb-0" style="font-weight: 700; color: var(--text-primary);">Edit Profile</h2>
                </div>
            </div>

            <!-- Profile Edit Form -->
            <div class="card border-0 shadow-sm" style="border-radius: var(--border-radius); background: var(--card-background);">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="text-center mb-4 pb-4" style="border-bottom: 1px solid var(--border-color);">
                            <div class="position-relative d-inline-block mb-3">
                                <img id="profile-preview" src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/120' }}" class="rounded-circle border" style="width: 120px; height: 120px; object-fit: cover; border: 3px solid var(--border-color) !important;">
                                <div class="position-absolute bottom-0 end-0 bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; cursor: pointer;" onclick="document.getElementById('profile_image').click();">
                                    <i class="fas fa-camera text-white" style="font-size: 0.9rem;"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="file" class="d-none @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(this)">
                                <label for="profile_image" class="btn btn-outline-primary btn-sm" style="border-radius: 50px;">
                                    <i class="fas fa-upload me-2"></i>
                                    Change Photo
                                </label>
                                @error('profile_image')
                                <div class="invalid-feedback d-block mt-2">
                                    <strong>{{ $message }}</strong>
                                </div>
                                @enderror
                            </div>
                            <p class="text-muted mb-0" style="font-size: 0.85rem;">JPG, PNG or GIF. Max size 2MB</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label fw-semibold" style="color: var(--text-primary); margin-bottom: 0.75rem;">
                                    <i class="fas fa-user me-2 text-muted"></i>
                                    Full Name
                                </label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required style="border-radius: 12px; border: 1px solid var(--border-color); padding: 0.875rem 1rem; font-size: 0.95rem;" placeholder="Enter your full name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="username" class="form-label fw-semibold" style="color: var(--text-primary); margin-bottom: 0.75rem;">
                                    <i class="fas fa-at me-2 text-muted"></i>
                                    Username
                                </label>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', $user->username) }}" required style="border-radius: 12px; border: 1px solid var(--border-color); padding: 0.875rem 1rem; font-size: 0.95rem;" placeholder="Choose a unique username">
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="bio" class="form-label fw-semibold" style="color: var(--text-primary); margin-bottom: 0.75rem;">
                                <i class="fas fa-quote-left me-2 text-muted"></i>
                                Bio
                            </label>
                            <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" name="bio" rows="4" style="border-radius: 12px; border: 1px solid var(--border-color); padding: 0.875rem 1rem; font-size: 0.95rem; resize: vertical;" placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                            <div class="form-text" style="font-size: 0.8rem; color: var(--text-secondary);">
                                Write a short bio to tell people about yourself
                            </div>
                            @error('bio')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 1px solid var(--border-color);">
                            <a href="{{ route('profile.show', $user->id) }}" class="btn btn-light" style="border-radius: 50px; padding: 0.75rem 1.5rem; font-weight: 500;">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary" style="border-radius: 50px; padding: 0.75rem 2rem; font-weight: 600; background: var(--primary-color); border: none;">
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

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

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

<style>
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.1rem rgba(0, 123, 255, 0.25);
    }

    .btn-primary:hover {
        background-color: #0056b3 !important;
        box-shadow: var(--shadow-medium) !important;
        color: white;
    }

    .btn-light:hover {
        background-color: var(--hover-color);
        border-color: var(--border-color);
    }

    #profile-preview {
        transition: all 0.3s ease;
    }

    #profile-preview:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .btn,
    .form-control {
        transition: all 0.2s ease;
    }
</style>
@endsection