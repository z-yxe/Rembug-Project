@extends('layouts.app')

@section('content')
<div class="create-post-container">
    <div class="container-inner">
        <div class="bg-body border rounded-4 p-4 p-md-5 shadow-sm create-post-card">
            {{-- Header formulir diubah untuk 'Edit' --}}
            <div class="form-header">
                <h2 class="fw-bold fs-5 d-flex align-items-center border-bottom pb-4 mb-4">
                    <div class="icon-wrapper">
                        {{-- Ikon diubah menjadi ikon edit --}}
                        <i class="fas fa-edit"></i>
                    </div>
                    Edit Post
                </h2>
            </div>

            {{-- Form disesuaikan untuk proses UPDATE --}}
            <form method="POST" action="{{ route('posts.update', $post->id) }}">
                @csrf
                @method('PATCH') {{-- Metode PATCH untuk update --}}

                {{-- Input Caption --}}
                <div class="mb-4 pt-2">
                    <label for="caption" class="form-label fw-semibold text-body mb-2 d-flex align-items-center">
                        <i class="fas fa-pen-fancy me-2 text-primary"></i>Caption
                    </label>
                    <div class="position-relative">
                        {{-- Textarea diisi dengan data caption yang ada --}}
                        <textarea id="caption" class="form-control enhanced-textarea @error('caption') is-invalid @enderror" name="caption" rows="4" placeholder="Update your thoughts..." maxlength="500" oninput="updateCharCount(this)">{{ old('caption', $post->caption) }}</textarea>
                        <div class="char-counter">
                            <span id="charCount">0</span>/500
                        </div>
                    </div>
                    @error('caption')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Bagian Unggah Gambar Dihapus --}}

                {{-- Tombol Submit diubah untuk 'Update' --}}
                <div class="d-grid d-md-flex justify-content-md-end mt-5 pt-3 border-top">
                    <button type="submit" class="btn btn-primary enhanced-submit-btn" id="submitBtn">
                        <span class="btn-content d-flex align-items-center justify-content-center">
                            {{-- Ikon diubah menjadi ikon simpan --}}
                            <i class="fas fa-save me-2"></i>
                            <span class="btn-text">Update Post</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Semua style CSS dari create-post dipertahankan --}}
<style>
    .create-post-container {
        padding: 0.2rem 0;
    }
    .container-inner {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    .icon-wrapper { background: white; color: var(--primary-color); width: 20px; height: 20px; border-radius: 5px; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-size: 1em; box-shadow: var(--shadow-light); }
    .enhanced-textarea { border-radius: 12px; border: 2px solid var(--border-color); background-color: var(--card-background); color: var(--text-primary); padding: 1rem 1.25rem; font-size: 0.95rem; line-height: 1.5; transition: all 0.3s ease; resize: vertical; min-height: 120px; }
    .enhanced-textarea:focus { border-color: var(--primary-color); box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-rgb, 0, 123, 255), 0.15); background-color: var(--card-background); transform: translateY(-1px); }
    .char-counter { position: absolute; bottom: 12px; right: 15px; font-size: 0.75rem; color: var(--text-secondary); background: var(--card-background); padding: 2px 6px; border-radius: 10px; border: 1px solid var(--border-color); }
    .enhanced-submit-btn { font-weight: 600; font-size: 0.95rem; border-radius: 12px; padding: 0.75rem 2rem; min-width: 150px; height: 50px; }
    
    /* Perbaikan untuk Tablet */
    @media (max-width: 991.98px) {
        .create-post-container {
            padding-top: 0.7rem;
        }
        .container-inner {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    }
    /* Perbaikan untuk Mobile */
    @media (max-width: 767.98px) {
        .enhanced-submit-btn {
            width: 100%;
        }
        .create-post-container {
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .container-inner {
            padding: 0;
        }
        .create-post-card {
            border-radius: 0 !important; 
            box-shadow: none !important;
            padding: 1.5rem !important;
        }
    }
</style>

{{-- Hanya JavaScript untuk character counter yang dipertahankan --}}
<script>
    function updateCharCount(textarea) {
        const charCount = document.getElementById('charCount');
        charCount.textContent = textarea.value.length;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const captionTextarea = document.getElementById('caption');
        if(captionTextarea) {
            updateCharCount(captionTextarea);
        }
    });
</script>
@endsection