@extends('layouts.app')

@section('content')
<div class="edit-post-form-container">
    <div class="card-style-theme" style="background: var(--card-background); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 2rem; box-shadow: var(--shadow-medium);">
        <h2 class="mb-4 pb-3" style="font-weight: 700; color: var(--text-primary); font-size: 1.4rem; display: flex; align-items: center; letter-spacing: -0.02em; border-bottom: 1px solid var(--border-color);">
            <i class="fas fa-edit me-3" style="color: var(--primary-color); font-size: 1em;"></i>
            Edit Post
        </h2>

        <form method="POST" action="{{ route('posts.update', $post->id) }}">
            @csrf
            @method('PATCH')

            <!-- Caption edit -->
            <div class="mb-4 pt-2">
                <label for="caption" class="form-label" style="font-weight: 500; color: var(--text-primary); font-size: 0.9rem; margin-bottom: 0.5rem;">Caption</label>
                <textarea id="caption" class="form-control @error('caption') is-invalid @enderror" name="caption" rows="4" style="border-radius: 8px;  border-color: var(--border-color);  background-color: var(--card-background); color: var(--text-primary);  padding: 0.75rem 1rem; box-shadow: var(--shadow-light);"placeholder="Update your caption...">{{ old('caption', $post->caption) }}</textarea>
                @error('caption')
                    <span class="invalid-feedback" role="alert" style="font-size: 0.85rem;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5 pt-3" style="border-top: 1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary-themed px-4 py-2" style="background-color: var(--primary-color); color: white;  font-weight: 600;  font-size: 0.95rem; border-radius: 8px;  border: none; transition: all 0.2s ease; box-shadow: var(--shadow-light);">
                    <i class="fas fa-save me-2"></i>Update Post
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .btn-primary-themed:hover {
        background-color: #0056b3 !important;
        box-shadow: var(--shadow-medium) !important;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-rgb, 0, 123, 255), 0.25);
        background-color: var(--card-background); 
    }
</style>
@endsection