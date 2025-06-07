@extends('layouts.app')

@section('content')
<div class="search-container">
    <div class="search-header mb-4">
        <div class="search-card">
            <div class="search-card-body">
                <h3 class="search-title mb-3">
                    <i class="fas fa-search me-2"></i>
                    Pencarian
                </h3>
                <form action="{{ route('search.index') }}" method="GET" class="search-form">
                    <div class="search-input-wrapper">
                        <input type="text" name="q" class="search-input" placeholder="Cari postingan, pengguna..." value="{{ $query ?? old('q') }}" aria-label="Search query">
                        <button class="search-btn" type="submit">
                            <i class="fas fa-search"></i>
                            <span class="btn-text">Cari</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    @if(isset($query) && $query)
    @if(isset($userResults) && $userResults->count() > 0)
    <div class="results-section mb-5">
        <div class="section-header">
            <h4 class="section-title">
                <i class="fas fa-users me-2"></i>
                Pengguna Ditemukan
            </h4>
            <div class="section-divider"></div>
        </div>

        <div class="users-grid">
            @foreach($userResults as $user)
            <div class="user-result-card">
                <a href="{{ route('profile.show', $user->id) }}" class="user-result-link">
                    <div class="user-result-avatar">
                        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/56' }}"
                            alt="{{ $user->username }}">
                    </div>
                    <div class="user-result-info">
                        <div class="user-result-username">{{ $user->username }}</div>
                        @if($user->name)
                        <div class="user-result-fullname">{{ $user->name }}</div>
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
        <div class="pagination-wrapper">
            {{ $userResults->appends(['q' => $query])->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
    @endif

    <!-- Post Results -->
    @if(isset($postResults) && $postResults->count() > 0)
    <div class="results-section">
        <div class="section-header">
            <h4 class="section-title">
                <i class="fas fa-images me-2"></i>
                Postingan Ditemukan
            </h4>
            <div class="section-divider"></div>
        </div>

        <div class="posts-grid">
            @foreach($postResults as $post)
            <article class="post-result-card">
                <div class="post-result-header">
                    @if($post->user)
                    <a href="{{ route('profile.show', $post->user->id) }}" class="post-user-link">
                        <img src="{{ $post->user->profile_image ? asset('storage/' . $post->user->profile_image) : 'https://via.placeholder.com/36' }}"
                            class="post-user-avatar"
                            alt="{{ $post->user->username }}">
                        <div class="post-user-info">
                            <span class="post-username">{{ $post->user->username }}</span>
                            <span class="post-timestamp">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </a>
                    @else
                    <div class="post-user-link">
                        <img src="https://via.placeholder.com/36" class="post-user-avatar" alt="Deleted User">
                        <div class="post-user-info">
                            <span class="post-username deleted">Pengguna Dihapus</span>
                            <span class="post-timestamp">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @endif
                </div>

                @if($post->image_path)
                <div class="post-result-image">
                    <a href="{{ route('posts.show', $post->id) }}">
                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image">
                    </a>
                </div>
                @endif

                <div class="post-result-content">
                    <p class="post-caption">{{ Str::limit($post->caption, 120) }}</p>
                    <a href="{{ route('posts.show', $post->id) }}" class="post-view-btn">
                        <i class="fas fa-eye me-1"></i>
                        Lihat Postingan
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        @if ($postResults->hasPages())
        <div class="pagination-wrapper">
            {{ $postResults->appends(['q' => $query])->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
    @endif

    <!-- No Results -->
    @if(isset($query) && $query && (!isset($userResults) || $userResults->isEmpty()) && (!isset($postResults) || $postResults->isEmpty()))
    <div class="no-results">
        <div class="no-results-icon">
            <i class="fas fa-search"></i>
        </div>
        <h4 class="no-results-title">Tidak Ada Hasil</h4>
        <p class="no-results-text">
            Kami tidak dapat menemukan apapun untuk "<strong>{{ $query }}</strong>".
            <br>Coba kata kunci pencarian yang berbeda.
        </p>
    </div>
    @endif

    @elseif(isset($query) && !$query && request()->has('q'))
    <div class="empty-search">
        <div class="empty-search-icon">
            <i class="fas fa-keyboard"></i>
        </div>
        <p class="empty-search-text">Silakan masukkan kata kunci untuk mencari postingan atau pengguna.</p>
    </div>
    @endif
</div>

<style>
    /* Search Page Styles */
    .search-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 1rem;
    }

    /* Search Header */
    .search-card {
        background: var(--card-background);
        border-radius: var(--border-radius, 12px);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-modern, 0 4px 12px rgba(0, 0, 0, 0.06));
        overflow: hidden;
    }

    .search-card-body {
        padding: 1.5rem;
    }

    .search-title {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 1.2rem;
        margin-bottom: 1rem;
    }

    .search-title .fas {
        font-size: 1.05rem;
        margin-right: 0.4rem;
    }

    .search-input-wrapper {
        display: flex;
        gap: 0;
        border-radius: var(--border-radius-input, 10px);
        overflow: hidden;
        border: 1px solid var(--border-color-input, var(--border-color));
        transition: all 0.2s ease-in-out;
    }

    .search-input-wrapper:focus-within {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(var(--primary-rgb, 0, 123, 255), 0.15);
    }

    .search-input {
        flex: 1;
        border: none;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        background: transparent;
        outline: none;
        color: var(--text-primary);
    }

    .search-input::placeholder {
        color: var(--text-secondary);
        opacity: 0.8;
    }

    .search-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.75rem 1.25rem;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out, transform 0.1s ease;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.9rem;
    }

    .search-btn .fas {
        font-size: 0.85rem;
    }

    .search-btn:hover {
        background: var(--primary-darker, #0056b3);
    }

    .search-btn:active {
        transform: scale(0.98);
    }


    .btn-text {
        display: inline-block;
    }

    /* Responsive Design Adjustments for Search Card */
    @media (max-width: 767px) {
        .search-container {
            padding: 0.75rem;
        }
        
        .search-card-body {
            padding: 1.25rem;
        }
        
        .search-title {
            font-size: 1.1rem;
        }
        
        .search-title .fas {
            font-size: 1rem;
        }
        
        .search-input-wrapper {
            flex-direction: column;
            border-radius: var(--border-radius-input, 10px);
        }

        .search-input {
            text-align: center;
            padding: 0.8rem 1rem;
        }

        .search-btn {
            border-radius: 0;
            justify-content: center;
            padding: 0.8rem 1rem;
            font-size: 0.9rem;
        }

        .search-btn .fas {
            font-size: 0.9rem;
        }

        .btn-text {
            display: none;
        }
    }

    /* Results Sections */
    .results-section {
        margin-bottom: 2.5rem;
    }

    .section-header {
        margin-bottom: 1.25rem;
    }

    .section-title {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.4rem;
    }

    .section-title .fas {
        font-size: 1rem;
    }

    .section-divider {
        height: 2px;
        background: linear-gradient(90deg, var(--primary-color) 0%, transparent 100%);
        border-radius: 1px;
    }

    /* User Results */
    .users-grid {
        display: grid;
        gap: 0.9rem;
        grid-template-columns: 1fr;
    }

    .user-result-card {
        background: var(--card-background);
        border-radius: var(--border-radius);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .user-result-card:hover {
        border-color: var(--primary-color);
        box-shadow: var(--shadow-medium);
        transform: translateY(-2px);
    }

    .user-result-link {
        display: flex;
        align-items: center;
        padding: 1rem;
        text-decoration: none;
        color: inherit;
    }

    .user-result-avatar {
        margin-right: 0.9rem;
        flex-shrink: 0;
    }

    .user-result-avatar img {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--border-color);
    }

    .user-result-info {
        flex: 1;
    }

    .user-result-username {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 1rem;
        margin-bottom: 0.2rem;
    }

    .user-result-fullname {
        color: var(--text-secondary);
        font-size: 0.85rem;
    }

    .user-result-arrow {
        color: var(--text-secondary);
        transition: all 0.2s ease;
    }

    .user-result-arrow .fas {
        font-size: 0.9rem;
    }


    .user-result-card:hover .user-result-arrow {
        color: var(--primary-color);
        transform: translateX(4px);
    }

    /* Post Results */
    .posts-grid {
        display: grid;
        gap: 1.25rem;
        grid-template-columns: 1fr;
    }

    .post-result-card {
        background: var(--card-background);
        border-radius: var(--border-radius);
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .post-result-card:hover {
        box-shadow: var(--shadow-medium);
        transform: translateY(-2px);
    }

    .post-result-header {
        padding: 0.9rem 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .post-user-link {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: inherit;
    }

    .post-user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 0.65rem;
        border: 1px solid var(--border-color);
    }

    .post-user-info {
        flex: 1;
    }

    .post-username {
        font-weight: 600;
        color: var(--text-primary);
        display: block;
        font-size: 0.9rem;
    }

    .post-username.deleted {
        color: var(--text-secondary);
        font-style: italic;
    }

    .post-timestamp {
        color: var(--text-secondary);
        font-size: 0.75rem;
        display: block;
        margin-top: 0.1rem;
    }

    .post-result-image {
        position: relative;
        overflow: hidden;
    }

    .post-result-image img {
        width: 100%;
        height: 280px;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }

    .post-result-image:hover img {
        transform: scale(1.02);
    }

    .post-result-content {
        padding: 1rem;
    }

    .post-caption {
        color: var(--text-primary);
        line-height: 1.5;
        margin-bottom: 0.9rem;
        font-size: 0.9rem;
    }

    .post-view-btn {
        display: inline-flex;
        align-items: center;
        padding: 0.4rem 0.8rem;
        background: var(--primary-color);
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }

    .post-view-btn .fas {
        font-size: 0.8rem;
        margin-right: 0.3rem;
    }


    .post-view-btn:hover {
        background: #0056b3;
        color: white;
        transform: translateY(-1px);
    }

    /* No Results & Empty State */
    .no-results,
    .empty-search {
        text-align: center;
        padding: 3rem 1.5rem;
        background: var(--card-background);
        border-radius: var(--border-radius);
        border: 1px solid var(--border-color);
    }

    .no-results-icon,
    .empty-search-icon {
        font-size: 2.8rem;
        color: var(--text-secondary);
        margin-bottom: 1.25rem;
        opacity: 0.7;
    }

    .no-results-icon .fas,
    .empty-search-icon .fas {
        font-size: inherit;
    }

    .no-results-title {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.9rem;
        font-size: 1.3rem;
    }

    .no-results-text,
    .empty-search-text {
        color: var(--text-secondary);
        line-height: 1.5;
        font-size: 0.95rem;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 1.75rem;
    }

    /* Responsive Design */
    @media (min-width: 768px) {
        .users-grid {
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
        }

        .posts-grid {
            grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
        }

        .btn-text {
            display: inline-block;
        }
    }

    @media (max-width: 767px) {
        .user-result-avatar img {
            width: 48px;
            height: 48px;
        }

        .user-result-username {
            font-size: 0.95rem;
        }

        .user-result-fullname {
            font-size: 0.8rem;
        }

        .post-result-image img {
            height: 220px;
        }

        .post-caption {
            font-size: 0.85rem;
        }

        .post-view-btn {
            font-size: 0.8rem;
        }

        .no-results,
        .empty-search {
            padding: 2.5rem 1rem;
        }

        .no-results-icon,
        .empty-search-icon {
            font-size: 2.5rem;
        }

        .no-results-title {
            font-size: 1.1rem;
        }

        .no-results-text,
        .empty-search-text {
            font-size: 0.9rem;
        }
    }
</style>
@endsection