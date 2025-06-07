@extends('layouts.app')

@section('content')
<div class="create-post-form-container">
    <div class="card-style-theme" style="background: var(--card-background); border: 1px solid var(--border-color); border-radius: var(--border-radius); padding: 2rem; box-shadow: var(--shadow-medium); position: relative; overflow: hidden;">
        <div class="form-header">
            <h2 class="mb-4 pb-4" style="font-weight: 700; color: var(--text-primary); font-size: 1.4rem; display: flex; align-items: center; letter-spacing: -0.02em; border-bottom: 1px solid var(--border-color); position: relative; z-index: 2;">
                <div class="icon-wrapper">
                    <i class="far fa-plus-square"></i>
                </div>
                Create New Post
            </h2>
        </div>

        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" style="position: relative; z-index: 2;">
            @csrf

            <!-- Caption input -->
            <div class="mb-4 pt-2">
                <label for="caption" class="form-label enhanced-label">
                    <i class="fas fa-pen-fancy me-2"></i>Caption
                </label>
                <div class="input-wrapper">
                    <textarea id="caption" class="form-control enhanced-textarea @error('caption') is-invalid @enderror" name="caption" rows="4" placeholder="Share your thoughts... What's on your mind?"maxlength="500"oninput="updateCharCount(this)">{{ old('caption') }}</textarea>
                    <div class="char-counter">
                        <span id="charCount">0</span>/500
                    </div>
                </div>
                @error('caption')
                    <span class="invalid-feedback" role="alert" style="font-size: 0.85rem;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Image upload section -->
            <div class="mb-4">
                <label class="form-label enhanced-label">
                    <i class="fas fa-image me-2"></i>Image
                </label>
                <input type="file" class="form-control visually-hidden @error('image') is-invalid @enderror" id="image" name="image"accept="image/jpeg,image/png,image/gif,image/webp"onchange="handleImageUpload(this)">       
                
                <div id="image-upload-container" class="image-upload-container">
                    <label for="image" id="image-upload-visual-cue" class="image-upload-area">
                        <div class="upload-content">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="upload-text">
                                <p class="upload-title">Drop your image here or click to browse</p>
                                <p class="upload-subtitle">Supports JPG, PNG, GIF, WebP (Max 10MB)</p>
                            </div>
                        </div>
                    </label>
                    
                    <!-- Image preview area -->
                    <div id="imagePreview" class="image-preview-container" style="display: none;">
                        <div class="preview-header">
                            <span class="preview-title">Image Preview</span>
                            <button type="button" class="remove-image-btn" onclick="removeImage()">
                                <i class="fas fa-times"></i>
                            </button>
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
                
                @error('image')
                    <span class="invalid-feedback d-block" role="alert" style="font-size: 0.85rem;">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Submit button -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5 pt-3" style="border-top: 1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary-themed enhanced-submit-btn" id="submitBtn">
                    <span class="btn-content">
                        <i class="fas fa-paper-plane me-2"></i>
                        <span class="btn-text">Share Post</span>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .form-header {
        position: relative;
    }

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

    .enhanced-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
    }

    .enhanced-label i {
        color: var(--primary-color);
        font-size: 0.9em;
    }

    .input-wrapper {
        position: relative;
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

    .image-upload-container {
        position: relative;
    }

    .image-upload-area {
        display: block;
        border: 2px dashed var(--border-color);
        border-radius: 16px;
        background: linear-gradient(135deg, var(--hover-color) 0%, rgba(var(--primary-color-rgb, 0, 123, 255), 0.02) 100%);
        padding: 3rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .image-upload-area:hover {
        border-color: var(--primary-color);
        background: linear-gradient(135deg, rgba(var(--primary-color-rgb, 0, 123, 255), 0.05) 0%, rgba(var(--primary-color-rgb, 0, 123, 255), 0.02) 100%);
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .upload-content {
        position: relative;
        z-index: 2;
    }

    .upload-icon {
        margin-bottom: 1rem;
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

    .remove-image-btn {
        background: #dc3545;
        color: white;
        border: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .remove-image-btn:hover {
        background: #c82333;
        transform: scale(1.1);
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

    .enhanced-submit-btn {
        background: var(--primary-color);
        color: white;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 12px;
        border: none;
        padding: 0.75rem 2rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-light);
        min-width: 150px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .enhanced-submit-btn:hover {
        background-color: #0056b3 !important;
        box-shadow: var(--shadow-medium) !important;
        color: white;
    }

    @media (max-width: 768px) {
        .create-post-form-container .card-style-theme {
            padding: 1.5rem;
        }
        
        .image-upload-area {
            padding: 2rem 1rem;
        }
        
        .upload-icon i {
            font-size: 2.5rem;
        }
        
        .enhanced-submit-btn {
            width: 100%;
        }
    }
</style>

<script>
    function updateCharCount(textarea) {
        const charCount = document.getElementById('charCount');
        const currentLength = textarea.value.length;
        charCount.textContent = currentLength;
        
        if (currentLength > 450) {
            charCount.style.color = '#dc3545';
        } else if (currentLength > 400) {
            charCount.style.color = '#ffc107';
        } else {
            charCount.style.color = 'var(--text-secondary)';
        }
    }

    function handleImageUpload(input) {
        const file = input.files[0];
        const uploadArea = document.getElementById('image-upload-visual-cue');
        const previewContainer = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const fileName = document.getElementById('imageFileName');
        const fileSize = document.getElementById('imageFileSize');

        if (file) {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please select a valid image file (JPG, PNG, GIF, WebP)');
                input.value = '';
                return;
            }

            if (file.size > 10 * 1024 * 1024) {
                alert('File size must be less than 10MB');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                
                uploadArea.style.display = 'none';
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    function removeImage() {
        const input = document.getElementById('image');
        const uploadArea = document.getElementById('image-upload-visual-cue');
        const previewContainer = document.getElementById('imagePreview');
        
        input.value = '';
        uploadArea.style.display = 'block';
        previewContainer.style.display = 'none';
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const submitBtn = document.getElementById('submitBtn');
        const btnContent = submitBtn.querySelector('.btn-content');

        form.addEventListener('submit', function(e) {
            btnContent.style.display = 'none';
            submitBtn.disabled = true;
            
            const caption = document.getElementById('caption').value.trim();
            const image = document.getElementById('image').files[0];
            
            if (!caption && !image) {
                e.preventDefault();
                alert('Please add a caption or select an image to share your post.');
                btnContent.style.display = 'flex';
                submitBtn.disabled = false;
                return;
            }
        });

        const captionTextarea = document.getElementById('caption');
        updateCharCount(captionTextarea);
    });

    const uploadArea = document.getElementById('image-upload-visual-cue');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight(e) {
        uploadArea.style.borderColor = 'var(--primary-color)';
        uploadArea.style.backgroundColor = 'rgba(var(--primary-color-rgb, 0, 123, 255), 0.1)';
    }
    
    function unhighlight(e) {
        uploadArea.style.borderColor = 'var(--border-color)';
        uploadArea.style.backgroundColor = '';
    }
    
    uploadArea.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        const imageInput = document.getElementById('image');
        
        if (files.length > 0) {
            imageInput.files = files;
            handleImageUpload(imageInput);
        }
    }
</script>
@endsection