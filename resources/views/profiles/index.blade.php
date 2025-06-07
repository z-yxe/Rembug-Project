@extends('layouts.app')

@section('content')
<div class="profile-container">
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

    <!-- Profile Header Card -->
    <div class="profile-header-card">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 text-center text-md-start mb-4 mb-md-0">
                <div class="profile-image-container">
                    <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/150' }}"
                        class="profile-image" alt="{{ $user->username }}">
                </div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="profile-info">
                    <div class="profile-header-row">
                        <h1 class="profile-username">@ {{ $user->username }}</h1>
                        <div class="profile-actions">
                            @auth
                            @if(Auth::id() === $user->id)
                            <a href="{{ route('profile.edit', $user->id) }}" class="btn-profile-action btn-edit">
                                <i class="fas fa-edit me-2"></i>
                                Edit Profile
                            </a>
                            @else
                            @if(Auth::user()->isFollowing($user))
                            <form action="{{ route('follow.destroy', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-profile-action btn-unfollow">
                                    <i class="fas fa-user-minus me-2"></i>
                                    Unfollow
                                </button>
                            </form>
                            @else
                            <form action="{{ route('follow.store', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-profile-action btn-follow">
                                    <i class="fas fa-user-plus me-2"></i>
                                    Follow
                                </button>
                            </form>
                            @endif
                            @endif
                            @endauth
                        </div>
                    </div>

                    <div class="profile-stats">
                        <div class="stat-item">
                            <span class="stat-number">{{ $user->posts->count() }} <span class="stat-label">posts</span></span>
                            
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $user->followers->count() }} <span class="stat-label">followers</span></span>
                            
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $user->following->count() }} <span class="stat-label">following</span></span>
                            
                        </div>
                    </div>

                    <div class="profile-bio">
                        <h5 class="profile-fullname">{{ $user->name }}</h5>
                        <p class="profile-description">{{ $user->bio ?: 'No bio yet.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Section -->
    <div class="posts-section">
        <div class="posts-header">
            <h4 class="posts-title">
                <i class="fas fa-th me-2"></i>
                Posts
            </h4>
            <div class="posts-count">{{ $user->posts->count() }} {{ Str::plural('post', $user->posts->count()) }}</div>
        </div>

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

<style>
    /* Profile Container */
    .profile-container {
        max-width: 100%;
        padding: 0;
    }

    /* Modern Alert Styling */
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

    /* Profile Header Card */
    .profile-header-card {
        background: var(--card-background);
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-medium);
        transition: all 0.3s ease;
    }

    /* Profile Image */
    .profile-image-container {
        position: relative;
        display: inline-block;
    }

    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--border-color);
        transition: all 0.3s ease;
        box-shadow: var(--shadow-medium);
    }

    /* Profile Info */
    .profile-info {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .profile-header-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .profile-username {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        letter-spacing: -0.02em;
    }
    
    .profile-actions {
        display: flex;
        gap: 0.5rem;
    }

    /* Profile Action Buttons */
    .btn-profile-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-edit {
        background: var(--hover-color);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-edit:hover {
        background: var(--text-secondary);
        color: white;
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
        background: transparent;
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
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
        gap: 1.5rem;
        margin-bottom: 1rem;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .stat-number {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.9rem;
        color: var(--text-secondary);
        font-weight: 500;
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
        border-radius: var(--border-radius);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-light);
        overflow: hidden;
        margin-top: 2rem;
    }

    .posts-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .posts-title {
        font-size: 1.3rem;
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

    .posts-grid {
        padding: 1.5rem;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    .post-item {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: var(--shadow-light);
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
    }

    .post-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
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
        background: rgba(0, 0, 0, 0.55);
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

    /* Empty Posts Section */
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

    /* Button to create first post */
    .btn-create-first-post {
        background: var(--primary-color);
        color: white;
        padding: 0.8rem 1.5rem;
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

    @media (max-width: 991px) {
        .posts-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .profile-header-card {
            padding: 1.5rem;
        }

        .profile-username {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 768px) {
        .profile-header-card {
            padding: 1.5rem;
        }

        .profile-header-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-info .text-md-start {
            text-align: start !important;
        }

        .profile-header-row .profile-actions {
            width: 100%;
            justify-content: flex-start;
            margin-top: 0.5rem;
        }

        .profile-stats {
            justify-content: flex-start;
        }

        .posts-grid {
            padding: 1rem;
            gap: 0.75rem;
        }

        .posts-header {
            padding: 1rem 1.5rem;
            flex-direction: column;
            gap: 0.75rem;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .profile-image {
            width: 100px;
            height: 100px;
        }

        .profile-status-indicator {
            width: 15px;
            height: 15px;
            bottom: 5px;
            right: 5px;
        }

        .profile-username {
            font-size: 1.6rem;
        }

        .profile-stats {
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .stat-item {
            align-items: center;
        }

        .posts-grid {
            grid-template-columns: 1fr;
            padding: 1rem 0.75rem;
        }

        .posts-header {
            padding: 1rem;
        }

        .btn-profile-action {
            width: 100%;
            justify-content: center;
            margin-bottom: 0.5rem;
        }

        .profile-actions {
            flex-direction: column;
            width: 100%;
        }

        .profile-actions form {
            width: 100%;
        }

        .profile-actions form button {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection