<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Instacamp') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --background-color: #fafbfc;
            --card-background: #ffffff;
            --text-primary: #1a1a1a;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --hover-color: #f3f4f6;
            --shadow-light: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-medium: 0 4px 6px rgba(0, 0, 0, 0.07);
            --border-radius: 12px;
            --navbar-height: 64px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--background-color);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        #app {
            min-height: 100vh;
        }

        /* Navbar Styling */
        .navbar {
            background: var(--card-background) !important;
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(8px);
            box-shadow: var(--shadow-light);
            height: var(--navbar-height);
            padding: 0.75rem 0;
            position: relative;
            z-index: 1040;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            text-decoration: none;
            letter-spacing: -0.02em;
        }

        .brand-text-lobster {
            font-family: "Lobster", sans-serif;
            font-weight: 400;
            font-style: normal;
            font-size: 1.8rem;
        }

        .navbar-nav .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-nav .nav-link:hover {
            background-color: var(--hover-color);
            color: var(--text-primary) !important;
        }

        .dropdown-menu {
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-medium);
            border-radius: var(--border-radius);
            padding: 0.5rem;
            margin-top: 0.5rem;
            z-index: 1050;
            background-color: var(--card-background);
            min-width: 200px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            color: var(--text-primary) !important;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .dropdown-item:hover {
            background-color: var(--hover-color) !important;
            color: var(--text-primary) !important;
        }

        .dropdown-item:focus {
            background-color: var(--hover-color) !important;
            color: var(--text-primary) !important;
        }

        .dropdown-item:active {
            background-color: var(--primary-color) !important;
            color: white !important;
        }

        .dropdown-menu {
            display: none;
        }
        
        .dropdown.show .dropdown-menu {
            display: block;
        }

        /* Main Layout */
        .main-content-area {
            height: calc(100vh - var(--navbar-height));
            background-color: var(--background-color);
        }

        .sticky-sidebar {
            position: sticky;
            top: var(--navbar-height);
            height: calc(100vh - var(--navbar-height));
            overflow-y: auto;
            background-color: var(--card-background);
            border-right: 1px solid var(--border-color);
        }

        /* Sidebar Styling */
        .sidebar-nav {
            padding: 1.5rem 0;
        }

        .sidebar-nav .nav-link {
            color: var(--text-secondary);
            font-weight: 500;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            margin: 0.25rem 0;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
        }

        /* Sidebar Navigation Hover Effects */
        .sidebar-nav .nav-link:hover,
        .offcanvas-body .nav-link:hover {
            background-color: var(--hover-color) !important;
            color: var(--text-primary) !important;
            transform: translateX(4px);
        }

        .sidebar-nav .nav-link.text-danger:hover,
        .offcanvas-body .nav-link.text-danger:hover {
            background-color: rgba(220, 53, 69, 0.1) !important;
            color: #dc3545 !important;
        }

        .sidebar-nav .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }

        .sidebar-nav .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* User Profile Cards */
        .user-profile-card {
            background: var(--card-background);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-light);
        }

        .user-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
            background: transparent;
        }

        .user-item:hover {
            background-color: var(--hover-color);
        }

        .user-avatar {
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .user-avatar:hover {
            border-color: var(--primary-color);
        }

        .user-info {
            flex-grow: 1;
            margin-left: 0.75rem;
        }

        .username {
            font-weight: 600;
            color: var(--text-primary);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .username:hover {
            color: var(--primary-color);
        }

        .user-fullname {
            color: var(--text-secondary);
            font-size: 0.8rem;
            margin-top: 0.1rem;
        }

        /* Buttons */
        .btn-follow {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            border: none;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-follow:hover {
            transform: translateY(-1px);
        }

        .btn-follow.follow {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-follow.follow:hover {
            background-color: #0056b3;
        }

        .btn-follow.unfollow {
            background-color: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-follow.unfollow:hover {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        /* Main Content */
        .main-content {
            background-color: var(--background-color);
            padding: 2rem;
            overflow-y: auto;
            height: calc(100vh - var(--navbar-height));
        }

        /* Right Sidebar */
        .right-sidebar {
            background-color: var(--card-background);
            border-left: 1px solid var(--border-color);
            padding: 2rem 1.5rem;
        }

        .sidebar-section {
            margin-bottom: 2rem;
        }

        .sidebar-title {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1.1rem;
            margin-bottom: 1rem;
            letter-spacing: -0.01em;
        }

        /* Footer */
        .footer-links {
            margin-top: auto;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.8rem;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: var(--primary-color);
        }

        /* Offcanvas */
        .offcanvas {
            background-color: var(--card-background);
        }

        .offcanvas-header {
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
        }

        .offcanvas-body {
            padding: 1.5rem;
        }

        /* Mobile Responsive */
        @media (max-width: 767.98px) {
            .navbar { 
                height: var(--mobile-navbar-height);
                position: fixed;
                top: 0;
                width: 100%;
                z-index: 1030; 
            }
            
            .navbar .container-fluid {
                padding-left: 1rem; 
                padding-right: 1rem;
            }

            .navbar-brand {
                font-size: 1.5rem; 
                margin-right: auto; 
            }
            
            .main-content-area {
                padding-top: var(--navbar-height);
            }

            .main-content {
                padding: rem; 
            }

            .navbar-collapse {
                display: none !important;
            }
        }

        /* Scrollbar Styling */
        .sticky-sidebar::-webkit-scrollbar,
        .main-content::-webkit-scrollbar {
            width: 6px;
        }

        .sticky-sidebar::-webkit-scrollbar-track,
        .main-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .sticky-sidebar::-webkit-scrollbar-thumb,
        .main-content::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 3px;
        }

        .sticky-sidebar::-webkit-scrollbar-thumb:hover,
        .main-content::-webkit-scrollbar-thumb:hover {
            background: var(--text-secondary);
        }

        /* Custom Toggle Button */
        .navbar-toggler {
            border: 1px solid var(--border-color);
            padding: 0.5rem;
            border-radius: 8px;
            background-color: transparent;
            transition: all 0.2s ease;
        }

        .navbar-toggler:hover {
            background-color: var(--hover-color);
            border-color: var(--text-secondary);
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.1rem rgba(0, 123, 255, 0.25);
            border-color: var(--primary-color);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2833, 37, 41, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            width: 1.25em; 
            height: 1.25em;
        }
    </style>
</head>

<body>
    <div id="app" class="d-flex flex-column vh-100">
        <nav class="navbar navbar-expand-md navbar-light">
            <div class="container-fluid px-4">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="brand-text-lobster">Rembug</span>
                </a>
                <!-- Mobile menu button - triggers offcanvas -->
                <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuOffcanvas" aria-controls="mobileMenuOffcanvas" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Desktop navigation -->
                <div class="collapse navbar-collapse d-none d-md-flex" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if (Auth::user()->profile_image)
                                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="{{ Auth::user()->username }}" class="user-avatar me-2" style="width: 28px; height: 28px;">
                                @else
                                <i class="fas fa-user-circle me-2" style="font-size: 1.5rem;"></i>
                                @endif
                                <span>{{ Auth::user()->username ?? Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('profile.show', Auth::user()->id) }}">
                                    <i class="fas fa-user me-2"></i>
                                    <span>{{ __('Profile') }}</span>
                                </a>
                                <a class="dropdown-item" href="{{ route('profile.edit', Auth::user()->id) }}">
                                    <i class="fas fa-gear me-2"></i>
                                    <span>{{ __('Settings') }}</span>
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    <span>{{ __('Logout') }}</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu Offcanvas -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenuOffcanvas" aria-labelledby="mobileMenuOffcanvasLabel">
            <div class="offcanvas-header">
                <h5 class="brand-text-lobster" id="mobileMenuOffcanvasLabel">Rembug</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    @auth

                    <!-- User Profile Card -->
                    <li class="nav-item mb-4">
                        <div class="user-profile-card">
                            <div class="d-flex align-items-center">
                                <a href="{{ route('profile.show', Auth::user()->id) }}">
                                    <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : 'https://via.placeholder.com/48' }}" class="user-avatar" style="width: 48px; height: 48px;" alt="{{ Auth::user()->username }}">
                                </a>
                                <div class="user-info">
                                    <a href="{{ route('profile.show', Auth::user()->id) }}" class="username">{{ Auth::user()->username }}</a>
                                    <div class="user-fullname">{{ Auth::user()->name }}</div>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    <!-- Navigation Items -->
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center text-dark" href="{{ route('posts.index') }}" style="padding: 0.75rem 1rem; border-radius: 8px;" data-bs-dismiss="offcanvas">
                            <i class="fas fa-home me-3"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center text-dark" href="{{ route('search.index') }}" style="padding: 0.75rem 1rem; border-radius: 8px;" data-bs-dismiss="offcanvas">
                            <i class="fas fa-search me-3"></i>
                            <span>Search</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center text-dark" href="{{ route('posts.create') }}" style="padding: 0.75rem 1rem; border-radius: 8px;" data-bs-dismiss="offcanvas">
                            <i class="fas fa-plus-square me-3"></i>
                            <span>New Post</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center text-dark" href="{{ route('profile.show', Auth::user()->id) }}" style="padding: 0.75rem 1rem; border-radius: 8px;" data-bs-dismiss="offcanvas">
                            <i class="fas fa-user-circle me-3"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                    
                    <!-- Discover People Section -->
                    <li class="nav-item mb-3 mt-4">
                        <h6 class="px-3 text-muted text-uppercase" style="font-size: 0.8rem; font-weight: 600;">Discover People</h6>
                    </li>
                    
                    @if(isset($randomUsersForSidebar) && $randomUsersForSidebar->count() > 0)
                        @foreach($randomUsersForSidebar->take(3) as $user)
                            <li class="nav-item mb-2">
                                <div class="user-item">
                                    <a href="{{ route('profile.show', $user->id) }}" data-bs-dismiss="offcanvas">
                                        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/40' }}" class="user-avatar" style="width: 40px; height: 40px;" alt="{{ $user->username }}">
                                    </a>
                                    <div class="user-info">
                                        <a href="{{ route('profile.show', $user->id) }}" class="username" data-bs-dismiss="offcanvas">{{ Str::limit($user->username, 15) }}</a>
                                        <div class="user-fullname">{{ Str::limit($user->name ?: 'User', 20) }}</div>
                                    </div>
                                    @if(Auth::id() !== $user->id)
                                    <div class="ms-2">
                                        @if(Auth::user()->isFollowing($user))
                                        <form action="{{ route('follow.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-follow unfollow">Unfollow</button>
                                        </form>
                                        @else
                                        <form action="{{ route('follow.store', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-follow follow">Follow</button>
                                        </form>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    @endif
                    
                    <!-- Logout Button -->
                    <li class="nav-item mt-4 pt-3" style="border-top: 1px solid var(--border-color);">
                        <a class="nav-link d-flex align-items-center text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();"
                            style="padding: 0.75rem 1rem; border-radius: 8px;">
                            <i class="fas fa-sign-out-alt me-3"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                    @else
                    <!-- Guest Navigation -->
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center text-dark" href="{{ route('login') }}" style="padding: 0.75rem 1rem; border-radius: 8px;" data-bs-dismiss="offcanvas">
                            <i class="fas fa-sign-in-alt me-3"></i>
                            <span>Login</span>
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link d-flex align-items-center text-dark" href="{{ route('register') }}" style="padding: 0.75rem 1rem; border-radius: 8px;" data-bs-dismiss="offcanvas">
                            <i class="fas fa-user-plus me-3"></i>
                            <span>Register</span>
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>

        <div class="container-fluid flex-grow-1 main-content-area">
            <div class="row h-100">
                
                <!-- Main Navigarion (Kiri) -->
                <aside class="col-md-3 col-lg-2 d-none d-md-flex flex-column sticky-sidebar">
                    <ul class="nav flex-column sidebar-nav">
                        @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('posts.index') }}"><i class="fas fa-home"></i>Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('search.index') }}"><i class="fas fa-search"></i>Search</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('posts.create') }}"><i class="fas fa-plus-square"></i>New Post</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile.show', Auth::user()->id) }}"><i class="fas fa-user-circle"></i>Profile</a></li>
                        @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i>Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus"></i>Register</a></li>
                        @endauth
                    </ul>
                    @auth
                    <div class="mt-auto pt-3 border-top" style="border-color: var(--border-color) !important;">
                        <a class="nav-link d-flex align-items-center text-danger" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();"
                            style="padding: 0.2rem 1.5rem; margin-bottom: 1rem; border-radius: 12px; transition: all 0.2s ease;">
                            <i class="fas fa-sign-out-alt me-3" style="width: 20px; text-align: center;"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                    @endauth
                </aside>

                <!-- Konten Utama (Tengah) -->
                <main class="col-12 col-md-6 col-lg-7 main-content">
                    @yield('content')
                </main>

                <!-- Random User (Kanan) -->
                <aside class="col-md-3 col-lg-3 d-none d-md-block sticky-sidebar right-sidebar d-flex flex-column">
                    @auth
                    <div class="user-profile-card">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('profile.show', Auth::user()->id) }}">
                                <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : 'https://via.placeholder.com/56' }}" class="user-avatar" style="width: 56px; height: 56px;" alt="{{ Auth::user()->username }}">
                            </a>
                            <div class="user-info">
                                <a href="{{ route('profile.show', Auth::user()->id) }}" class="username">{{ Auth::user()->username }}</a>
                                <div class="user-fullname">{{ Auth::user()->name }}</div>
                            </div>
                        </div>
                    </div>
                    @endauth

                    <div class="sidebar-section">
                        <h6 class="sidebar-title">Discover People</h6>
                        <div class="user-list-container">
                            @if(isset($randomUsersForSidebar) && $randomUsersForSidebar->count() > 0)
                                @foreach($randomUsersForSidebar as $user)
                                    <div class="user-item">
                                        <a href="{{ route('profile.show', $user->id) }}">
                                            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/40' }}" class="user-avatar" style="width: 40px; height: 40px;" alt="{{ $user->username }}">
                                        </a>
                                        <div class="user-info">
                                            <a href="{{ route('profile.show', $user->id) }}" class="username">{{ Str::limit($user->username, 15) }}</a>
                                            <div class="user-fullname">{{ Str::limit($user->name ?: 'User', 20) }}</div>
                                        </div>
                                        @auth
                                            @if(Auth::id() !== $user->id)
                                            <div class="ms-2">
                                                @if(Auth::user()->isFollowing($user))
                                                <form action="{{ route('follow.destroy', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-follow unfollow">Unfollow</button>
                                                </form>
                                                @else
                                                <form action="{{ route('follow.store', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn-follow follow">Follow</button>
                                                </form>
                                                @endif
                                            </div>
                                            @endif
                                        @endauth
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">No users to display.</p>
                            @endif
                        </div>
                    </div>

                    <footer class="footer-links mt-auto">
                        <p class="text-muted" style="font-size: 0.8rem;">&copy; {{ date('Y') }} REMBUG</p>
                    </footer>
                </aside>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>