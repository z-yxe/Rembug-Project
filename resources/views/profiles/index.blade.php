@extends('layouts.app')

@section('content')
<div class="profile-page-container">
    <div class="profile-container">

        {{-- Alert Notifications --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show modern-alert" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show modern-alert" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show modern-alert" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- Profile Header --}}
        <div class="profile-header-card">
            <div class="row align-items-center g-3 g-md-4">
                
                {{-- Profile Picture --}}
                <div class="col-auto">
                    <div class="profile-image-container">
                        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/150' }}"
                            class="profile-image" alt="{{ $user->username }}">
                    </div>
                </div>

                {{-- Profile Information --}}
                <div class="col">
                    <div class="profile-info">
                        <div class="profile-header-row">
                            <h1 class="profile-username">@ {{ $user->username }}</h1>
                            
                            {{-- Action Buttons --}}
                            <div class="profile-actions">
                                @auth
                                @if(Auth::id() === $user->id)
                                <a href="{{ route('profile.edit', $user->id) }}" class="btn-profile-action btn-edit">
                                    <i class="fas fa-edit me-1 me-md-2"></i>
                                    <span class="d-none d-md-inline">Edit Profile</span>
                                </a>
                                @else
                                    @if(Auth::user()->isFollowing($user))
                                    <form action="{{ route('follow.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-profile-action btn-unfollow">
                                            <i class="fas fa-user-minus me-2"></i>
                                            <span class="d-none d-md-inline">Unfollow</span>
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('follow.store', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-profile-action btn-follow">
                                            <i class="fas fa-user-plus me-2"></i>
                                            <span class="d-none d-md-inline">Follow</span>
                                        </button>
                                    </form>
                                    @endif
                                @endif
                                @endauth
                            </div>
                        </div>

                        {{-- Profile Statistics --}}
                        <div class="profile-stats">
                            <div class="stat-item">
                                <span class="stat-number">{{ $user->posts->count() }}</span>
                                <span class="stat-label">posts</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">{{ $user->followers->count() }}</span>
                                <span class="stat-label">followers</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">{{ $user->following->count() }}</span>
                                <span class="stat-label">following</span>
                            </div>
                        </div>

                        {{-- Profile Bio --}}
                        <div class="profile-bio">
                            <h5 class="profile-fullname">{{ $user->name }}</h5>
                            <p class="profile-description">{{ $user->bio ?: 'No bio yet.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Posts Section --}}
        <div class="posts-section">
            <div class="posts-header">
                <h4 class="posts-title">
                    <i class="fas fa-th me-2"></i>
                    Posts
                </h4>
                <div class="posts-count">{{ $user->posts->count() }} {{ Str::plural('post', $user->posts->count()) }}</div>
            </div>

            {{-- Posts Grid --}}
            <div class="posts-grid">
                @forelse($user->posts as $post)
                <div class="post-item">
                    <a href="{{ route('posts.show', $post->id) }}" class="post-link">
                        <div class="post-image-container">
                            <img src="{{ asset('storage/' . $post->image_path) }}"
                                class="post-image"
                                alt="Post by {{ $user->username }}">
                            <div class="post-overlay">
                                <div class="post-overlay-content">
                                    <i class="fas fa-eye"></i>
                                    <span>View Post</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                
                {{-- No Posts State --}}
                <div class="empty-posts">
                    <div class="empty-posts-icon">
                        <i class="fas fa-camera"></i>
                    </div>
                    <h5 class="empty-posts-title">No Posts Yet</h5>
                    <p class="empty-posts-text">
                        @if(Auth::check() && Auth::id() === $user->id)
                        Start sharing your moments by creating your first post!
                        @else
                        This user hasn't shared any posts yet.
                        @endif
                    </p>
                    @if(Auth::check() && Auth::id() === $user->id)
                    <a href="{{ route('posts.create') }}" class="btn-create-first-post">
                        <i class="fas fa-plus me-2"></i>
                        Create Your First Post
                    </a>
                    @endif
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    /* General Container */
    .profile-page-container {
        padding: 0rem 0;
    }

    .profile-container {
        max-width: 960px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    /* Alert */
    .modern-alert {
        background: var(--card-background);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    .modern-alert i {
        font-size: 1rem;
    }

    /* Profile Header */
    .profile-header-card {
        background: var(--card-background);
        border-radius: 16px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
    }

    .profile-image-container {
        position: relative;
        display: inline-block;
    }

    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid var(--border-color);
    }

    .profile-info {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin-left: 10px;
    }

    .profile-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        flex-wrap: nowrap;
        gap: 1rem;
    }

    .profile-username {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    /* Action Buttons */
    .profile-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-profile-action {
        padding: 0.6rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.85rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        white-space: nowrap;
    }

    .btn-edit {
        background: var(--hover-color);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-edit:hover {
        background: var(--border-color);
        color: var(--text-primary);
        transform: translateY(-1px);
    }

    .btn-follow {
        background: var(--primary-color);
        color: white;
    }

    .btn-follow:hover {
        background: #0056b3;
        transform: translateY(-1px);
    }

    .btn-unfollow {
        background: var(--hover-color);
        color: var(--text-secondary);
    }

    .btn-unfollow:hover {
        background: #dc3545;
        color: white;
        border-color: #dc3545;
        transform: translateY(-1px);
    }

    /* Profile Stats */
    .profile-stats {
        display: flex;
        gap: 2rem;
        margin-bottom: 1.5rem;
    }

    .stat-item {
        display: flex;
        align-items: baseline;
        gap: 0.4rem;
    }

    .stat-number {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--text-secondary);
    }

    /* Profile Bio */
    .profile-fullname {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.4rem;
    }

    .profile-description {
        color: var(--text-secondary);
        line-height: 1.6;
        margin: 0;
        font-size: 0.95rem;
    }

    /* Posts Section */
    .posts-section {
        background: var(--card-background);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    .posts-header {
        padding: 1.25rem 2rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .posts-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
    }

    .posts-count {
        background: var(--hover-color);
        color: var(--text-secondary);
        padding: 0.4rem 0.8rem;
        border-radius: 18px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Posts Grid */
    .posts-grid {
        padding: 1.5rem;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    .post-item {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: none;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .post-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        border-color: var(--border-color);
    }

    .post-link {
        display: block;
        text-decoration: none;
        position: relative;
    }

    .post-image-container {
        position: relative;
        aspect-ratio: 1;
        overflow: hidden;
        background-color: var(--hover-color);
    }

    .post-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .post-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .post-item:hover .post-overlay {
        opacity: 1;
    }

    .post-item:hover .post-image {
        transform: scale(1.05);
    }

    .post-overlay-content {
        color: white;
        text-align: center;
        font-weight: 600;
    }

    .post-overlay-content i {
        font-size: 1.5rem;
        margin-bottom: 0.4rem;
        display: block;
    }

    /* Empty State */
    .empty-posts {
        grid-column: 1 / -1;
        text-align: center;
        padding: 3rem 1.5rem;
    }

    .empty-posts-icon {
        font-size: 3rem;
        color: var(--text-secondary);
        margin-bottom: 1rem;
        opacity: 0.6;
    }

    .empty-posts-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
    }

    .empty-posts-text {
        color: var(--text-secondary);
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
        max-width: 380px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-create-first-post {
        background: var(--primary-color);
        color: white;
        padding: 0.8rem 1.5rem;
        margin-bottom: 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        transition: all 0.2s ease;
    }

    .btn-create-first-post:hover {
        background: #0056b3;
        transform: translateY(-2px);
        color: white;
        text-decoration: none;
    }

    /* Tablet Devices */
    @media (max-width: 991.98px) {
        .profile-page-container {
            padding-top: 1.5rem;
        }

        .profile-container {
            padding: 0 1.5rem;
        }

        .profile-header-card {
            padding: 2rem;
        }

        .profile-image {
            width: 120px;
            height: 120px;
        }

        .profile-username {
            font-size: 1.5rem;
        }

        .profile-stats {
            gap: 1.5rem;
            margin-bottom: 1.25rem;
            flex-wrap: wrap;
        }

        .stat-number {
            font-size: 1rem;
        }

        .stat-label {
            font-size: 0.85rem;
        }

        .profile-fullname {
            font-size: 1rem;
        }

        .profile-description {
            font-size: 0.9rem;
        }

        .btn-profile-action {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }
    }

    /* Mobile Devices */
    @media (max-width: 576px) {
        .profile-page-container {
            padding: 0;
        }

        .profile-container {
            padding: 0;
        }

        .modern-alert {
            border-radius: 0 !important;
            box-shadow: none !important;
            margin-top: 15px
        }

        .profile-header-card,
        .posts-section {
            border-radius: 0 !important;
            border-left: none !important;
            border-right: none !important;
            box-shadow: none !important;
            margin-bottom: 15px;
            margin-top: 5px;
            border-bottom: 1px solid var(--border-color);
        }

        .profile-header-card {
            padding: 1rem;
        }

        .profile-image {
            width: 75px;
            height: 75px;
        }

        .profile-header-row {
            margin-bottom: 0.75rem;
            gap: 0.5rem;
        }
        
        .profile-username {
            font-size: 1.2rem;
        }

        .profile-stats {
            justify-content: space-around;
            margin-bottom: 1rem;
            gap: 0;
            padding: 0.75rem 0;
            order: 3;
        }
        
        .profile-info {
            display: contents;
        }

        .profile-bio {
            order: 2;
            font-size: 0.85rem;
            padding: 0 0.5rem;
            margin-bottom: 1rem;
            text-align: left;
        }

        .stat-item {
            flex-direction: column;
            align-items: center;
            gap: 0;
        }

        .stat-number {
            font-size: 1rem;
            font-weight: 600;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .btn-profile-action {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
        }

        .btn-profile-action .fa-edit {
            margin-right: 0 !important;
        }
        
        .btn-follow .d-none.d-md-inline,
        .btn-unfollow .d-none.d-md-inline {
            display: none !important;
        }

        .btn-follow .me-2,
        .btn-unfollow .me-2 {
            margin-right: 0 !important;
        }

        .posts-grid {
            padding: 0.5rem;
            gap: 0.25rem;
            grid-template-columns: repeat(2, 1fr);
        }

        .posts-header {
            padding: 1rem 1.5rem;
        }

        .posts-title {
            font-size: 1rem;
        }

        .posts-count {
            font-size: 0.8rem;
        }

        .empty-posts-icon {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
        }

        .empty-posts-title {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .empty-posts-text {
            font-size: 0.9rem;
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
        }
        
        .btn-create-first-post {
            padding: 0.6rem 1rem;
            font-size: 0.8rem;
        }
    }
</style>
@endsection