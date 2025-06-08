@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Main Post Card --}}
    <div class="post-show-card">
        <div class="row g-0">

            {{-- Image Column --}}
            <div class="col-lg-7 post-image-column">
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image by {{ $post->user->username ?? 'user' }}" class="post-image-display">
            </div>

            {{-- Info & Comments Column --}}
            <div class="col-lg-5 d-flex flex-column border-lg-start">
                <div class="p-3 flex-grow-1 d-flex flex-column">

                    {{-- User Info Header --}}
                    <div class="post-header-info">
                        @if($post->user)
                        <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none d-flex align-items-center">
                            <img src="{{ $post->user->profile_image ? asset('storage/' . $post->user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->username) . '&background=E8F0FE&color=007BFF&size=40&font-size=0.5&rounded=true' }}" alt="{{ $post->user->username }}" class="user-avatar-small me-3">
                            <div>
                                <span class="username-text">{{ $post->user->username }}</span>
                                <div class="post-date">{{ $post->created_at->format('F j, Y') }}</div>
                            </div>
                        </a>
                        
                        {{-- Post Options --}}
                        @if(auth()->check() && auth()->id() === $post->user_id)
                        <div class="dropdown ms-auto">
                            <button class="btn btn-link p-0 options-button" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="postOptions">
                                <li>
                                    <a class="dropdown-item" href="{{ route('posts.edit', $post->id) }}">
                                        <i class="fas fa-edit me-2"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-trash-alt me-2"></i>Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @endif
                        @else
                        {{-- Deleted User State --}}
                        <img src="https://ui-avatars.com/api/?name=D U&background=E8F0FE&color=007BFF&size=40&font-size=0.5&rounded=true" alt="Deleted User" class="user-avatar-small me-3">
                        <span class="deleted-user-text">Deleted User</span>
                        @endif
                    </div>

                    {{-- Post Caption --}}
                    <div class="caption-area">
                        @if($post->user)
                        <a href="{{ route('profile.show', $post->user->id) }}" class="username-link">{{ $post->user->username }}</a>
                        @endif
                        <span class="caption-text">{{ $post->caption }}</span>
                    </div>
                    
                    {{-- Actions & Likes --}}
                    <div class="actions-info-area">
                        <div class="d-flex align-items-center mb-1">
                            @if($post->likes->where('user_id', auth()->id())->count() > 0)
                            <form action="{{ route('likes.destroy', $post->id) }}" method="POST" class="me-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-0 like-button liked">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </form>
                            @else
                            <form action="{{ route('likes.store', $post->id) }}" method="POST" class="me-3">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 like-button">
                                    <i class="far fa-heart"></i>
                                </button>
                            </form>
                            @endif
                            
                            @if ($post->likes->count() > 0)
                            <span class="likes-count">
                                {{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Comments List --}}
                    <div class="comments-section">
                        @forelse($post->comments as $comment)
                        <div class="comment-item">
                            <div class="flex-grow-1">
                                <a href="{{ $comment->user ? route('profile.show', $comment->user->id) : '#' }}" class="username-link">
                                    {{ $comment->user ? $comment->user->username : 'Deleted User' }}
                                </a>
                                <span class="comment-text">{{ $comment->comment }}</span>
                            </div>
                            @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->id() === $post->user_id))
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="ms-2" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-0 delete-comment-button" title="Delete comment">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                        @empty
                        <p class="no-comments-text">No comments yet.</p>
                        @endforelse
                    </div>

                    {{-- Comment Input Form --}}
                    <div class="comment-form-area">
                        <form action="{{ route('comments.store', $post->id) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="comment" class="form-control comment-input" placeholder="Add a comment..." required>
                                <button class="btn comment-submit-btn" type="submit">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* General Styles */
    .container {
        padding: 0.2rem;
    }

    .post-show-card {
        background-color: var(--card-background);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-medium);
        overflow: hidden;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(var(--primary-color-rgb, 0, 123, 255), 0.25);
        background-color: var(--card-background);
    }

    /* Image Column */
    .post-image-column {
        background-color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid var(--border-color);
    }

    .post-image-display {
        max-width: 100%;
        height: auto;
        display: block;
        object-fit: contain;
    }

    /* Info & Comments Column */
    .post-header-info {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .user-avatar-small {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--border-color);
    }

    .username-text {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.95rem;
    }
    
    .username-link {
       font-weight: 600; 
       color: var(--text-primary);
       text-decoration: none;
       margin-right: 0.25rem;
    }

    .post-date {
        font-size: 0.8rem;
        color: var(--text-secondary);
        line-height: 1;
    }

    .options-button {
        color: var(--text-secondary);
    }
    
    .deleted-user-text {
        color: var(--text-secondary);
        font-style: italic;
    }
    
    .dropdown-item i {
        width: 16px;
    }
    
    /* Caption & Actions */
    .caption-area {
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .caption-text {
        color: var(--text-secondary);
        white-space: pre-wrap;
    }

    .actions-info-area {
        font-size: 0.9rem;
        border-bottom: 1px solid var(--border-color);
    }

    .like-button {
        font-size: 1.4rem;
        color: var(--text-secondary);
    }

    .like-button.liked {
        color: var(--bs-danger);
    }

    .likes-count {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.9rem;
    }

    /* Comments Section */
    .comments-section {
        flex-grow: 1;
        margin-bottom: 0.5rem;
        max-height: 250px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .comment-item {
        display: flex;
        margin-bottom: 0.5rem;
        margin-top: 0.5rem;
        align-items: flex-start;
        font-size: 0.85rem;
    }

    .comment-text {
        color: var(--text-secondary);
        white-space: pre-wrap;
    }

    .delete-comment-button {
        font-size: 0.8rem;
    }
    
    .no-comments-text {
        color: var(--text-secondary);
        font-size: 0.85rem;
        text-align: center;
        padding: 1rem 0;
    }

    /* Comment Form */
    .comment-form-area {
        margin-top: -0.3rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }

    .comment-input {
        border-radius: 16px 0 0 16px;
        border: 1px solid var(--border-color);
        background-color: var(--background-color);
        color: var(--text-primary);
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
        box-shadow: none;
    }

    .comment-submit-btn {
        border-radius: 0 16px 16px 0;
        background-color: var(--primary-color);
        color: white;
        font-weight: 500;
        font-size: 0.85rem;
        border: 1px solid var(--primary-color);
        padding: 0.5rem 1rem;
    }

    .comment-submit-btn i {
        font-size: 1rem;
    }

    /* Responsive Styles */
    @media (min-width: 992px) {
        .border-lg-start {
            border-left: 1px solid var(--border-color);
        }
    }
    
    @media (min-width: 768px) and (max-width: 991.98px) {
        .container {
            max-width: 90%;
            margin-top: 1rem;
        }
    }

    @media (max-width: 767.98px) {
        .container {
            padding-left: 0;
            padding-right: 0;
            margin-top: -0.9rem;
            max-width: 100%;
        }

        .post-show-card {
            border-radius: 0 !important;
            box-shadow: none !important;
        }

        .col-lg-5.d-flex.flex-column {
            border-top: 1px solid var(--border-color);
        }
    }
</style>
@endsection
