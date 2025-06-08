@extends('layouts.app')

@section('content')
{{-- Kontainer Utama Halaman --}}
<div class="create-post-container">
    <div class="container-inner">
        {{-- Kartu Formulir Buat Postingan --}}
        <div class="bg-body border rounded-4 p-4 p-md-5 shadow-sm create-post-card">
            
            {{-- Header Formulir --}}
            <div class="form-header">
                <h2 class="fw-bold fs-5 d-flex align-items-center border-bottom pb-4 mb-4">
                    <div class="icon-wrapper">
                        <i class="far fa-plus-square"></i>
                    </div>
                    Create New Post
                </h2>
            </div>

            {{-- Formulir Utama --}}
            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Input Field Caption --}}
                <div class="mb-4 pt-2">
                    <label for="caption" class="form-label fw-semibold text-body mb-2 d-flex align-items-center">
                        <i class="fas fa-pen-fancy me-2 text-primary"></i>Caption
                    </label>
                    <div class="position-relative">
                        <textarea id="caption" class="form-control enhanced-textarea @error('caption') is-invalid @enderror" name="caption" rows="4" placeholder="Share your thoughts... What's on your mind?" maxlength="500" oninput="updateCharCount(this)">{{ old('caption') }}</textarea>
                        {{-- Penghitung Karakter --}}
                        <div class="char-counter">
                            <span id="charCount">0</span>/500
                        </div>
                    </div>
                    {{-- Pesan Error Validasi Caption --}}
                    @error('caption')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Input Field Unggah Gambar --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold text-body mb-2 d-flex align-items-center">
                        <i class="fas fa-image me-2 text-primary"></i>Image
                    </label>
                    <input type="file" class="visually-hidden @error('image') is-invalid @enderror" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp" onchange="handleImageUpload(this)"> 
                    
                    <div id="image-upload-container">
                        {{-- Area Visual untuk Drag & Drop --}}
                        <label for="image" id="image-upload-visual-cue" class="image-upload-area">
                            <div class="upload-content">
                                <div class="upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <div class="upload-text">
                                    <p class="upload-title">Drop your image here or click to browse</p>
                                    <p class="upload-subtitle">Supports JPG, PNG, GIF, WebP (Max 2MB)</p>
                                </div>
                            </div>
                        </label>
                        
                        {{-- Kontainer Pratinjau Gambar --}}
                        <div id="imagePreview" class="image-preview-container" style="display: none;">
                            <div class="preview-header">
                                <span class="preview-title">Image Preview</span>
                                <button type="button" class="btn-close" aria-label="Remove Image" onclick="removeImage()"></button>
                            </div>
                            <div class="image-preview">
                                <img id="previewImg" src="" alt="Preview" />
                            </div>
                            <div class="image-info">
                                <span id="imageFileName" class="file-name"></span>
                                <span id="imageFileSize" class="file-size"></span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Pesan Error Validasi Gambar --}}
                    @error('image')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Tombol Aksi Formulir --}}
                <div class="d-grid d-md-flex justify-content-md-end mt-5 pt-3 border-top">
                    <button type="submit" class="btn btn-primary enhanced-submit-btn" id="submitBtn">
                        <span class="btn-content d-flex align-items-center justify-content-center">
                            <i class="fas fa-paper-plane me-2"></i>
                            <span class="btn-text">Share Post</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Gaya Kustom Halaman --}}
<style>
    /* Kontainer & Tata Letak */
    .create-post-container {
        padding: 0.2rem 0;
    }

    .container-inner {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    /* Elemen Formulir Umum */
    .icon-wrapper { 
        background: white; 
        color: var(--primary-color); 
        width: 20px; 
        height: 20px; 
        border-radius: 5px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        margin-right: 15px; 
        font-size: 1em; 
        box-shadow: var(--shadow-light); 
    }
    .enhanced-textarea { 
        border-radius: 12px; 
        border: 2px solid var(--border-color); 
        background-color: var(--card-background); 
        color: var(--text-primary); 
        padding: 1rem 1.25rem; 
        font-size: 0.95rem; 
        line-height: 1.5; 
        transition: all 0.3s ease; 
        resize: vertical; 
        min-height: 120px; 
    }
    .enhanced-textarea:focus { 
        border-color: var(--primary-color); 
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-rgb, 0, 123, 255), 0.15); 
        background-color: var(--card-background); 
        transform: translateY(-1px); 
    }
    .char-counter { 
        position: absolute; 
        bottom: 12px; 
        right: 15px; 
        font-size: 0.75rem; 
        color: var(--text-secondary); 
        background: var(--card-background); 
        padding: 2px 6px; 
        border-radius: 10px; 
        border: 1px solid var(--border-color); 
    }
    .enhanced-submit-btn { 
        font-weight: 600; 
        font-size: 0.95rem; 
        border-radius: 12px; 
        padding: 0.75rem 2rem; 
        min-width: 150px; 
        height: 50px; 
    }

    /* Area Unggah Gambar */
    .image-upload-area { 
        display: block; 
        border: 2px dashed var(--border-color); 
        border-radius: 16px; 
        background: linear-gradient(135deg, var(--hover-color) 0%, rgba(var(--primary-color-rgb, 0, 123, 255), 0.02) 100%); 
        padding: 3rem 2rem; 
        text-align: center; 
        cursor: pointer; 
        transition: all 0.3s ease; 
        overflow: hidden; 
    }
    .image-upload-area:hover, .image-upload-area.highlight { 
        border-color: var(--primary-color); 
        background: linear-gradient(135deg, rgba(var(--primary-color-rgb, 0, 123, 255), 0.05) 0%, rgba(var(--primary-color-rgb, 0, 123, 255), 0.02) 100%); 
        transform: translateY(-2px); 
        box-shadow: var(--shadow-medium); 
    }
    .upload-icon i { 
        font-size: 3rem; 
        color: var(--primary-color); 
        opacity: 0.8; 
        transition: all 0.3s ease; 
    }
    .image-upload-area:hover .upload-icon i { 
        transform: translateY(-5px); 
        opacity: 1; 
    }
    .upload-title { 
        font-size: 1.1rem; 
        font-weight: 600; 
        color: var(--text-primary); 
        margin-bottom: 0.5rem; 
    }
    .upload-subtitle { 
        font-size: 0.85rem; 
        color: var(--text-secondary); 
        margin: 0; 
    }

    /* Area Pratinjau Gambar */
    .image-preview-container { 
        background: var(--card-background); 
        border: 2px solid var(--border-color); 
        border-radius: 16px; 
        padding: 1.5rem; 
        margin-top: 1rem; 
        animation: fadeIn 0.3s ease; 
    }
    @keyframes fadeIn { 
        from { opacity: 0; transform: translateY(10px); } 
        to { opacity: 1; transform: translateY(0); } 
    }
    .preview-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 1rem; 
        padding-bottom: 0.5rem; 
        border-bottom: 1px solid var(--border-color); 
    }
    .preview-title { 
        font-weight: 600; 
        color: var(--text-primary); 
        font-size: 0.9rem; 
    }
    .image-preview { 
        text-align: center; 
        margin-bottom: 1rem; 
    }
    .image-preview img { 
        max-width: 100%; 
        max-height: 300px; 
        border-radius: 12px; 
        box-shadow: var(--shadow-light); 
        object-fit: cover; 
    }
    .image-info { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        font-size: 0.8rem; 
        color: var(--text-secondary); 
    }
    .file-name { 
        font-weight: 500; 
        max-width: 60%; 
        overflow: hidden; 
        text-overflow: ellipsis; 
        white-space: nowrap; 
    }
    .file-size { 
        font-weight: 600; 
        color: var(--primary-color); 
    }
    
    /* Gaya Responsif */
    @media (max-width: 991.98px) {
        .create-post-container {
            padding-top: 0.7rem;
        }
        .container-inner {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    }

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

{{-- Skrip Kustom Halaman --}}
<script>
    // Memperbarui tampilan hitungan karakter pada textarea.
    function updateCharCount(textarea) {
        const charCount = document.getElementById('charCount');
        charCount.textContent = textarea.value.length;
    }

    // Menangani file gambar yang dipilih dan menampilkan pratinjau.
    function handleImageUpload(input) {
        const file = input.files[0];
        const uploadCue = document.getElementById('image-upload-visual-cue');
        const previewContainer = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const fileName = document.getElementById('imageFileName');
        const fileSize = document.getElementById('imageFileSize');

        if (file) {
            // Validasi tipe file
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please select a valid image file (JPG, PNG, GIF, WebP)');
                input.value = '';
                return;
            }
            
            // Validasi ukuran file (2MB)
            if (file.size > 2 * 1024 * 1024) { 
                alert('File size must not exceed 2MB. Your server currently has this limit.');
                input.value = '';
                return;
            }

            // Membaca dan menampilkan file
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                uploadCue.style.display = 'none';
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    // Menghapus gambar pratinjau dan mereset input file.
    function removeImage() {
        const input = document.getElementById('image');
        const uploadCue = document.getElementById('image-upload-visual-cue');
        const previewContainer = document.getElementById('imagePreview');
        
        input.value = ''; // Membersihkan input file
        uploadCue.style.display = 'block';
        previewContainer.style.display = 'none';
    }

    // Memformat ukuran file dari bytes menjadi unit yang lebih mudah dibaca.
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Menambahkan fungsionalitas drag and drop untuk area unggah gambar.
    const uploadArea = document.getElementById('image-upload-visual-cue');
    if(uploadArea) {
        // Mencegah perilaku default browser
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });
        
        // Menambahkan highlight saat file diseret ke area
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => uploadArea.classList.add('highlight'), false);
        });
        
        // Menghapus highlight saat file meninggalkan area
        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, () => uploadArea.classList.remove('highlight'), false);
        });
        
        // Menangani file yang di-drop
        uploadArea.addEventListener('drop', e => {
            const imageInput = document.getElementById('image');
            imageInput.files = e.dataTransfer.files;
            handleImageUpload(imageInput);
        }, false);
    }

    // Menginisialisasi penghitung karakter saat DOM selesai dimuat.
    document.addEventListener('DOMContentLoaded', function() {
        const captionTextarea = document.getElementById('caption');
        if(captionTextarea) {
            updateCharCount(captionTextarea);
        }
    });
</script>
@endsection