@extends('layouts.app')

@section('content')

<div class="posts-container">
    @forelse($posts as $post)
    <article class="post-card">
        
        <!-- Post Header -->
        <header class="post-header">
            @if($post->user)
                <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none d-flex align-items-center enhanced-user-link">
                    <div class="user-avatar-wrapper">
                        <img src="{{ $post->user->profile_image ? asset('storage/' . $post->user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($post->user->username) . '&background=E8F0FE&color=007BFF&size=40&font-size=0.5&rounded=true' }}" alt="{{ $post->user->username }}" class="user-avatar">
                    </div>
                    <div class="user-info">
                        <span class="username">{{ $post->user->username }}</span>
                        <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </a>
                @if(auth()->id() === $post->user_id)
                <div class="post-actions">
                    <button class="action-btn" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="1"></circle>
                            <circle cx="12" cy="5" r="1"></circle>
                            <circle cx="12" cy="19" r="1"></circle>
                        </svg>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('posts.edit', $post->id) }}">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Edit
                        </a></li>
                        <li>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item danger">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3,6 5,6 21,6"></polyline>
                                        <path d="M19,6v14a2,2 0 0,1-2,2H7a2,2 0 0,1-2-2V6m3,0V4a2,2 0 0,1,2-2h4a2,2 0 0,1,2,2v2"></path>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endif
            @else
                <div class="user-info">
                    <div class="avatar">
                        <img src="https://ui-avatars.com/api/?name=D U&background=6B7280&color=FFFFFF&size=48&font-size=0.5&rounded=true" alt="Deleted User">
                    </div>
                    <div class="user-details">
                        <h3 class="username deleted">Deleted User</h3>
                        <time class="post-time">{{ $post->created_at->diffForHumans() }}</time>
                    </div>
                </div>
            @endif
        </header>

        <!-- Post Image -->
        <div class="post-image">
            <a href="{{ route('posts.show', $post->id) }}">
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post by {{ $post->user->username ?? 'user' }}" loading="lazy">
            </a>
        </div>

        <!-- Post Content -->
        <div class="post-content">
            
            <!-- Action Buttons -->
            <div class="post-interactions">
                <div class="interaction-buttons">
                    <div class="interaction-group">
                        @if($post->likes->where('user_id', auth()->id())->count() > 0)
                        <form action="{{ route('likes.destroy', $post->id) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="interaction-btn liked">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </button>
                        </form>
                        @else
                        <form action="{{ route('likes.store', $post->id) }}" method="POST" class="inline-form">
                            @csrf
                            <button type="submit" class="interaction-btn">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                </svg>
                            </button>
                        </form>
                        @endif
                        @if ($post->likes->count() > 0)
                        <span class="interaction-count">{{ number_format($post->likes->count()) }}</span>
                        @endif
                    </div>
                    
                    <div class="interaction-group">
                        <a href="{{ route('posts.show', $post->id) }}#comments" class="interaction-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </a>
                        @if ($post->comments->count() > 0)
                        <span class="interaction-count">{{ number_format($post->comments->count()) }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Caption -->
            @if($post->caption)
            <div class="caption">
                <span class="caption-text">{{ Str::limit($post->caption, 200) }}</span>
                @if(strlen($post->caption) > 200)
                <a href="{{ route('posts.show', $post->id) }}" class="show-more">more</a>
                @endif
            </div>
            @endif
        </div>
        
        <hr>

        <div class="post-comment">
            <!-- Comments Preview -->
            @if ($post->comments->count() > 0)
                <div class="comments-preview">
                    @foreach($post->comments->take(2) as $comment)
                    <div class="comment">
                        <a href="{{ $comment->user ? route('profile.show', $comment->user->id) : '#' }}" class="comment-username">{{ $comment->user ? $comment->user->username : 'Deleted User' }}</a>
                        <span class="comment-text">{{ Str::limit($comment->comment, 80) }}</span>
                    </div>
                    @endforeach
                </div>

                @if ($post->comments->count() > 2)
                <a href="{{ route('posts.show', $post->id) }}#comments" class="view-all-comments">
                    View all {{ $post->comments->count() }} comments
                </a>
                @endif
            @endif

            <!-- Add Comment Form -->
            <form action="{{ route('comments.store', $post->id) }}" method="POST" class="comment-form">
                @csrf
                <div class="comment-input-wrapper">
                    <input type="text" name="comment" placeholder="Add a comment..." required>
                    <button type="submit" class="comment-submit">
                        <i class="fa-solid fa-arrow-right" style="font-size: 1rem;"></i>
                    </button>
                </div>
            </form>
        </div>
    </article>

    @empty
    <!-- Empty State -->
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                <line x1="8" y1="21" x2="16" y2="21"></line>
                <line x1="12" y1="17" x2="12" y2="21"></line>
            </svg>
        </div>
        <h2 class="empty-title">No Posts Yet</h2>
        <p class="empty-description">Follow people or create your own masterpiece!</p>
        <a href="{{ route('posts.create') }}" class="create-post-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Create New Post
        </a>
    </div>
    @endforelse
</div>

@if($posts->hasPages())
<div class="pagination-wrapper">
    {{ $posts->links() }}
</div>
@endif

<style>
:root {
    --gray-50: #F9FAFB;
    --gray-100: #F3F4F6;
    --gray-200: #E5E7EB;
    --gray-300: #D1D5DB;
    --gray-400: #9CA3AF;
    --gray-500: #6B7280;
    --gray-600: #4B5563;
    --gray-700: #374151;
    --gray-800: #1F2937;
    --gray-900: #111827;
    --red-500: #EF4444;
    --red-600: #DC2626;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --radius-sm: 0.375rem;
    --radius-md: 0.5rem;
    --radius-lg: 0.75rem;
    --radius-xl: 1rem;
}

hr {
    color: var(--gray-400);
}

.posts-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 0 16px;
    gap: 24px;
    display: flex;
    flex-direction: column;
}

.post-card {
    background: white;
    border-radius: var(--radius-xl);
    border: 1px solid var(--gray-200);
    overflow: hidden;
    transition: all 0.2s ease;
}

/* Post Header */
.post-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--gray-100);
}

.user-avatar-wrapper {
    position: relative;
    margin-right: 12px;
}

.user-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--card-background);
    transition: all 0.3s ease;
}

.user-info {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.username {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.95rem;
    line-height: 1.2;
    margin-bottom: 2px;
}

.deleted-username {
    color: var(--text-secondary);
    font-style: italic;
    font-size: 0.9rem;
    font-weight: 500;
}

.post-time {
    font-size: 0.75rem;
    color: var(--text-secondary);
    opacity: 0.8;
}

.post-actions {
    position: relative;
}

.action-btn {
    background: none;
    border: none;
    color: var(--gray-500);
    cursor: pointer;
    padding: 8px;
    border-radius: var(--radius-md);
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-btn:hover {
    background: var(--gray-100);
    color: var(--gray-700);
}

/* Post Image */
.post-image {
    position: relative;
    aspect-ratio: 1/1;
    overflow: hidden;
}

.post-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

/* Post Content */
.post-content {
    padding: 16px 20px 0px;
}

.post-comment {
    padding: 0px 20px 20px;
}

.post-interactions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
}

.interaction-buttons {
    display: flex;
    gap: 20px;
}

.interaction-group {
    display: flex;
    align-items: center;
    gap: 8px;
}

.interaction-count {
    font-size: 14px;
    font-weight: 600;
    color: var(--gray-700);
    min-width: fit-content;
}

.inline-form {
    display: inline;
}

.interaction-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
    border-radius: var(--radius-md);
    transition: all 0.2s ease;
    color: var(--gray-700);
    display: flex;
    align-items: center;
    justify-content: center;
}

.interaction-btn:hover {
    transform: scale(1.1);
}

.interaction-btn.liked {
    color: var(--red-500);
}

.caption {
    font-size: 14px;
    line-height: 1.5;
    color: var(--gray-700);
    margin-bottom: 8px;
}

.caption-text {
    white-space: pre-wrap;
}

.show-more {
    color: var(--gray-500);
    text-decoration: none;
    font-weight: 500;
    margin-left: 4px;
}

.show-more:hover {
    color: var(--gray-700);
}

.view-all-comments {
    font-size: 14px;
    color: var(--gray-500);
    text-decoration: none;
    margin-bottom: 8px;
    display: block;
}

.view-all-comments:hover {
    color: var(--gray-700);
}

.comments-preview {
    margin-bottom: 12px;
}

.comment {
    font-size: 14px;
    line-height: 1.4;
    margin-bottom: 4px;
}

.comment-username {
    font-weight: 600;
    color: var(--gray-900);
    text-decoration: none;
    margin-right: 8px;
}

.comment-text {
    color: var(--gray-700);
}

.comment-form {
    margin-top: 12px;
}

.comment-input-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-lg);
    background: var(--gray-50);
    transition: all 0.2s ease;
}

.comment-input-wrapper:focus-within {
    border-color: var(--primary-color);
    background: white;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.comment-input-wrapper input {
    flex: 1;
    border: none;
    background: none;
    outline: none;
    font-size: 14px;
    color: var(--gray-700);
}

.comment-input-wrapper input::placeholder {
    color: var(--gray-400);
}

.comment-submit {
    background: var(--primary-color);
    padding: 2px 12px;
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
}

.comment-submit:hover {
    background: #0056b3;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 64px 32px;
    background: white;
    border-radius: var(--radius-xl);
    border: 1px solid var(--gray-200);
}

.empty-icon {
    color: var(--gray-300);
    margin-bottom: 24px;
}

.empty-title {
    font-size: 24px;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0 0 8px 0;
}

.empty-description {
    font-size: 16px;
    color: var(--gray-500);
    margin: 0 0 32px 0;
}

.create-post-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--primary-500);
    color: white;
    padding: 12px 24px;
    border-radius: var(--radius-lg);
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.2s ease;
    box-shadow: var(--shadow-md);
}

.create-post-btn:hover {
    background: var(--primary-600);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    color: white;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 32px;
    margin-bottom: 32px;
}

.pagination .page-item .page-link {
    color: var(--gray-600);
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-md);
    margin: 0 4px;
    padding: 8px 12px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    text-decoration: none;
}

.pagination .page-item .page-link:hover {
    background: var(--gray-100);
    border-color: var(--gray-300);
    color: var(--gray-700);
}

.pagination .page-item.active .page-link {
    background: var(--primary-500);
    border-color: var(--primary-500);
    color: white;
    box-shadow: var(--shadow-sm);
}

.pagination .page-item.disabled .page-link {
    color: var(--gray-400);
    background: var(--gray-50);
    border-color: var(--gray-200);
    cursor: not-allowed;
}

/* Dropdown Menu */
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
    background: rgba(239, 68, 68, 0.1);
    color: var(--red-600);
}

/* Responsive Design */
@media (max-width: 768px) {
    .posts-container {
        max-width: 100%;
        padding: 0 12px;
        gap: 16px;
    }
}

@media (max-width: 576px) {
    .posts-container {
        padding: 0 12px;
        gap: 16px;
    }
    
    .post-header {
        padding: 12px 16px;
    }
    
    .empty-state {
        padding: 48px 24px;
    }
    
    .empty-title {
        font-size: 20px;
    }
    
    .empty-description {
        font-size: 14px;
    }
}
</style>
@endsection