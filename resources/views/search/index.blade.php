@extends('layouts.app')

@section('content')
<div class="container-lg py-1">
    {{-- Search Form --}}
    <form action="{{ route('search.index') }}" method="GET" class="search-form mb-5">
        <div class="d-flex border rounded-4 overflow-hidden search-input-wrapper">
            <input type="text" name="q" class="form-control flex-grow-1 border-0 bg-transparent shadow-none search-input" placeholder="Cari postingan, pengguna..." value="{{ $query ?? old('q') }}" aria-label="Search query">
            <button class="btn btn-primary d-flex align-items-center gap-2 rounded-start-0 search-btn" type="submit">
                <i class="fas fa-search"></i>
                <span class="btn-text">Cari</span>
            </button>
        </div>
    </form>

    @if(isset($query) && $query)

        {{-- User Results --}}
        @if($userResults->isNotEmpty())
        <div class="results-section">
            <h4 class="section-title">
                <i class="fas fa-users me-3"></i>Pengguna Ditemukan
            </h4>
            <div class="grid gap-3">
                @foreach($userResults as $user)
                <div class="user-result-card">
                    <a href="{{ route('profile.show', $user->id) }}" class="d-flex align-items-center p-3 text-decoration-none text-body user-result-link">
                        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->username) . '&background=E8F0FE&color=007BFF&size=56&font-size=0.5&rounded=true' }}" alt="{{ $user->username }}" class="rounded-circle object-fit-cover me-3 user-result-avatar">
                        <div class="flex-grow-1">
                            <div class="fw-semibold text-dark user-result-username">{{ $user->username }}</div>
                            @if($user->name)
                            <div class="text-secondary small user-result-fullname">{{ $user->name }}</div>
                            @endif
                        </div>
                        <div class="user-result-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @if ($userResults->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $userResults->appends(['q' => $query])->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
        @endif

        {{-- Post Results --}}
        @if($postResults->isNotEmpty())
        <div class="results-section">
            <h4 class="section-title mt-5">
                <i class="fas fa-images me-3"></i>Postingan Ditemukan
            </h4>
            <div class="posts-grid">
                @foreach($postResults as $post)
                <article class="post-result-card">
                    <header class="d-flex align-items-center p-3 post-header">
                        @if($post->user)
                        <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none d-flex align-items-center text-body">
                            <img src="{{ $post->user->profile_image ? asset('storage/' . $post->user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->username) . '&background=E8F0FE&color=007BFF&size=40&font-size=0.5&rounded=true' }}" alt="{{ $post->user->username }}" class="rounded-circle object-fit-cover me-3 post-user-avatar">
                            <div>
                                <span class="fw-semibold text-dark post-username">{{ $post->user->username }}</span>
                                <div class="small text-secondary post-timestamp">{{ $post->created_at->diffForHumans() }}</div>
                            </div>
                        </a>
                        
                        @if(auth()->id() === $post->user_id)
                        <div class="dropdown post-actions ms-auto">
                            <button class="action-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle>
                                </svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('posts.edit', $post->id) }}">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item danger">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2">
                                                <polyline points="3,6 5,6 21,6"></polyline><path d="M19,6v14a2,2 0 0,1-2,2H7a2,2 0 0,1-2-2V6m3,0V4a2,2 0 0,1,2-2h4a2,2 0 0,1,2,2v2"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @endif
                        @endif
                    </header>
                    
                    <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none">
                        @if($post->image_path)
                        <div class="post-image">
                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="w-100 h-100 object-fit-cover">
                        </div>
                        @endif
                        @if($post->caption)
                        <div class="p-3">
                            <div class="caption">
                                <span class="text-secondary small">{{ Str::limit($post->caption, 120) }}</span>
                            </div>
                        </div>
                        @endif
                    </a>
                </article>
                @endforeach
            </div>
            @if ($postResults->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $postResults->appends(['q' => $query])->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
        @endif
        
        {{-- No Results Found --}}
        @if($userResults->isEmpty() && $postResults->isEmpty())
        <div class="text-center p-5 bg-body-tertiary rounded-3 border">
            <div class="no-results-icon"><i class="fas fa-search"></i></div>
            <h4 class="fw-semibold fs-5">Tidak Ada Hasil</h4>
            <p class="text-secondary">Kami tidak menemukan apapun untuk "<strong>{{ $query }}</strong>".</p>
        </div>
        @endif

    {{-- Empty Search State --}}
    @elseif(request()->has('q'))
    <div class="text-center p-5 bg-body-tertiary rounded-3 border">
        <div class="empty-search-icon"><i class="far fa-keyboard"></i></div>
        <p class="text-secondary">Silakan masukkan kata kunci untuk mencari.</p>
    </div>
    @endif
</div>

<style>
    /* CSS Variables */
    :root {
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-500: #6B7280;
        --gray-700: #374151;
        --gray-900: #111827;
        --red-600: #DC2626;
        --shadow-lg: 0 2px 8px 0 rgb(0 0 0 / 0.08);
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
    }

    /* Search Form */
    .search-input-wrapper:focus-within {
        border-color: var(--bs-primary) !important;
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
    }

    .search-btn .btn-text {
        font-weight: 600;
    }

    .search-input {
        font-size: 0.95rem;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
    
    /* Results Section */
    .section-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--bs-primary);
        border-bottom: 1px solid var(--bs-border-color);
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }

    /* User Result Card */
    .user-result-card {
        background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 15px;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }

    .user-result-card:hover {
        border-color: var(--bs-primary);
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }

    .user-result-avatar {
        width: 56px;
        height: 56px;
    }

    .user-result-arrow {
        color: var(--bs-secondary-color);
        transition: all 0.2s ease;
    }
    
    .user-result-card:hover .user-result-arrow {
        color: var(--bs-primary);
    }
    
    /* Post Results Grid */
    .posts-grid {
        display: grid;
        gap: 1.5rem;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }

    .post-result-card {
        background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .post-result-card:hover {
        border-color: var(--bs-primary);
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
    }
    
    .post-header {
        padding: 12px 16px;
    }

    .post-user-avatar {
        width: 40px;
        height: 40px;
    }
    
    .post-image {
        aspect-ratio: 1/1;
    }
    
    /* Dropdown Menu */
    .post-actions { 
        position: relative; 
    }

    .action-btn { 
        background: none; 
        border: none; 
        color: var(--gray-500); 
        cursor: pointer; 
        adding: 8px; 
        border-radius: var(--radius-md); 
        transition: all 0.2s ease; 
    }

    .action-btn:hover { 
        background: var(--gray-100); 
        color: var(--gray-700); 
    }

    .dropdown-menu { 
        border: 1px solid var(--gray-200); 
        border-radius: var(--radius-lg); 
        box-shadow: var(--shadow-lg); 
        padding: 8px; 
        min-width: 160px; 
    }

    .dropdown-item { 
        display: flex; 
        align-items: center; 
        gap: 8px; 
        padding: 8px 12px; 
        border-radius: var(--radius-md); 
        font-size: 14px; 
        color: var(--gray-700); 
        text-decoration: none; 
        border: none; 
        background: none; 
        width: 100%; 
        cursor: pointer; 
        transition: all 0.2s ease; 
    }

    .dropdown-item:hover { 
        background: var(--gray-100); 
        color: var(--gray-900); 
    }

    .dropdown-item.danger { 
        color: var(--red-600); 
    }

    .dropdown-item.danger:hover { 
        background: rgba(220, 38, 38, 0.1); 
        color: var(--red-600); 
    }
    
    /* Empty States */
    .no-results-icon, .empty-search-icon {
        font-size: 2rem;
        color: var(--bs-secondary-color);
        margin-bottom: 1.25rem;
    }
    
    /* Responsive */
    @media (max-width: 576px) {
        .search-btn .btn-text { display: none; }
        .search-btn { padding: 0.75rem 1rem; }
    }
</style>
@endsection
