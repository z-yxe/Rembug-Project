<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Pengaturan Meta Dasar --}}
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Rembug') }}</title>

    {{-- Pustaka & Font CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    {{-- Gaya Kustom CSS --}}
    <style>
        /* Variabel Global & Gaya Body */
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

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--background-color);
            color: var(--text-primary);
            line-height: 1.6;
            padding-top: var(--navbar-height);
        }

        /* Komponen Navbar Utama */
        .navbar {
            position: fixed !important;
            top: 0;
            width: 100%;
            z-index: 1030;
            background: var(--card-background) !important;
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-light);
            height: var(--navbar-height);
            padding: 0;
            display: flex;
            align-items: center;
        }

        .navbar .container-fluid {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .navbar-brand {
            margin-right: auto;
        }

        .brand-text-lobster {
            font-family: "Lobster", sans-serif;
            font-weight: 400;
            font-style: normal;
            font-size: 1.8rem;
        }

        .navbar-toggler {
            border: none;
            padding: 0.25rem 0rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* Komponen Sidebar Desktop */
        .sticky-sidebar {
            position: sticky;
            top: var(--navbar-height);
            height: calc(100vh - var(--navbar-height));
            overflow-y: auto;
            background-color: var(--card-background);
            display: flex;
            flex-direction: column;
        }

        .left-sidebar {
            border-right: 1px solid var(--border-color);
        }

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

        .sidebar-nav .nav-link:hover {
            background-color: var(--hover-color) !important;
            transform: translateX(4px);
        }

        .sidebar-nav .nav-link.active {
            background-color: var(--hover-color);
            color: var(--primary-color) !important;
            font-weight: 600;
        }

        .sidebar-nav .nav-link.active i {
            color: var(--primary-color);
        }

        .logout-section {
            margin-top: auto;
            border-top: 1px solid var(--border-color);
        }

        .logout-section .nav-link {
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

        /* Komponen Pengguna (Umum) */
        .user-profile-card {
            background: var(--card-background);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-light);
        }

        .user-item {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            border-radius: 10px;
            margin-bottom: 0.5rem;
        }

        .user-avatar {
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-color);
        }

        .user-info {
            flex-grow: 1;
            margin-left: 0.75rem;
            overflow: hidden;
        }

        .username {
            font-weight: 600;
            text-decoration: none;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .user-fullname {
            color: var(--text-secondary);
            font-size: 0.85rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .follow-btn-wrapper {
            min-width: 90px;
            text-align: center;
        }

        /* Area Konten & Sidebar Kanan */
        .main-content-area {
            height: calc(100vh - var(--navbar-height));
            overflow: hidden;
        }

        .main-content {
            background-color: var(--background-color);
            padding: 2rem;
            overflow-y: auto;
            height: calc(100vh - var(--navbar-height));
        }

        .right-sidebar {
            background-color: var(--card-background);
            border-left: 1px solid var(--border-color);
            padding: 2rem 1.5rem;
        }

        /* Navigasi Bawah Mobile */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            background-color: var(--card-background);
            border-top: 1px solid var(--border-color);
        }

        .mobile-bottom-nav .nav-list {
            display: flex;
            justify-content: space-around;
            list-style: none;
            padding: 0.5rem 0;
            margin: 0;
        }

        .mobile-bottom-nav .nav-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            text-decoration: none;
            width: 60px;
            height: 50px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .mobile-bottom-nav .nav-link:hover {
            background-color: var(--hover-color);
        }

        .mobile-bottom-nav .nav-link.active {
            color: var(--primary-color) !important;
        }

        .mobile-nav-icon {
            font-size: 22px !important;
            width: 22px !important;
            height: 22px !important;
            line-height: 1 !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
        }

        .mobile-nav-profile-img {
            width: 32px !important;
            height: 32px !important;
            border-radius: 50% !important;
            object-fit: cover !important;
            border: 1.5px solid var(--border-color) !important;
        }

        .nav-link .icon-solid { display: none; }
        .nav-link.active .icon-regular { display: none; }
        .nav-link.active .icon-solid {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .nav-link.active .mobile-nav-profile-img {
            border-color: var(--primary-color) !important;
        }

        /* Menu Samping Offcanvas (Mobile) */
        .offcanvas-header {
            border-bottom: 1px solid var(--border-color);
        }

        .offcanvas-body .nav-link {
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .offcanvas-body .nav-link:hover {
            background-color: var(--hover-color);
        }

        .offcanvas-body .nav-link i {
            width: 20px;
            text-align: center;
        }

        /* Aturan Responsif */
        @media (max-width: 991.98px) {
            .main-content {
                padding: 10px 0 80px 0;
            }

            .main-content-area {
                height: calc(100vh - var(--navbar-height));
                overflow: hidden;
            }
        }
    </style>
</head>

<body>
    {{-- Pembungkus Aplikasi Utama --}}
    <div id="app">
        {{-- Navbar Header --}}
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid px-4">
                {{-- Merek Aplikasi --}}
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="brand-text-lobster">Rembug</span>
                </a>

                {{-- Menu Pengguna Desktop --}}
                <div class="d-none d-lg-flex">
                    @auth
                    {{-- Dropdown Pengguna --}}
                    <div class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if (Auth::user()->profile_image)
                            <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="{{ Auth::user()->username }}" class="user-avatar" style="width: 32px; height: 32px;">
                            @else
                            <i class="fas fa-user-circle" style="font-size: 2rem;"></i>
                            @endif
                        </a>
                        {{-- Menu Dropdown --}}
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.show', Auth::user()->id) }}"><i class="fas fa-user fa-fw me-2"></i> {{ __('Profile') }}</a>
                            <a class="dropdown-item" href="{{ route('profile.edit', Auth::user()->id) }}"><i class="fas fa-gear fa-fw me-2"></i> {{ __('Settings') }}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt fa-fw me-2"></i> {{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </div>
                    </div>
                    @endauth
                </div>

                {{-- Tombol Toggle Mobile --}}
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuOffcanvas" aria-controls="mobileMenuOffcanvas" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>

        {{-- Menu Offcanvas Mobile --}}
        <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="mobileMenuOffcanvas" aria-labelledby="mobileMenuOffcanvasLabel">
            {{-- Header Offcanvas --}}
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="mobileMenuOffcanvasLabel">
                    <span class="brand-text-lobster" onclick="closeOffcanvasAndRedirect('{{ url('/') }}')" style="cursor: pointer;">Rembug</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            {{-- Body Offcanvas --}}
            <div class="offcanvas-body">
                <ul class="nav flex-column">
                    @auth
                    {{-- Kartu Profil Offcanvas --}}
                    <li class="nav-item">
                        <div class="user-profile-card">
                            <div class="d-flex align-items-center">
                                <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : 'https://via.placeholder.com/48' }}" class="user-avatar" style="width: 48px; height: 48px; cursor: pointer;" alt="{{ Auth::user()->username }}" onclick="closeOffcanvasAndRedirect('{{ route('profile.show', Auth::user()->id) }}')">
                                <div class="user-info">
                                    <span class="username" onclick="closeOffcanvasAndRedirect('{{ route('profile.show', Auth::user()->id) }}')" style="cursor: pointer;">{{ Auth::user()->username }}</span>
                                    <div class="user-fullname">{{ Auth::user()->name }}</div>
                                </div>
                            </div>
                        </div>
                    </li>

                    {{-- Judul Discover Offcanvas --}}
                    <li class="nav-item mb-3">
                        <h6 class="px-2 text-muted text-uppercase" style="font-size: 0.8rem; font-weight: 600;">Discover People</h6>
                    </li>
                    {{-- Daftar Pengguna Acak --}}
                    @if(isset($randomUsersForSidebar) && $randomUsersForSidebar->count() > 0)
                    @foreach($randomUsersForSidebar->take(5) as $user)
                    <li class="nav-item user-item">
                        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/40' }}" class="user-avatar" style="width: 40px; height: 40px; cursor: pointer;" alt="{{ $user->username }}" onclick="closeOffcanvasAndRedirect('{{ route('profile.show', $user->id) }}')">
                        <div class="user-info">
                            <span class="username" onclick="closeOffcanvasAndRedirect('{{ route('profile.show', $user->id) }}')" style="cursor: pointer;">{{ Str::limit($user->username, 12) }}</span>
                            <div class="user-fullname">{{ Str::limit($user->name ?: 'New User', 15) }}</div>
                        </div>
                        @if(Auth::id() !== $user->id)
                        {{-- Tombol Follow/Unfollow --}}
                        <div class="ms-auto follow-btn-wrapper">
                            @if(Auth::user()->isFollowing($user))
                            <form action="{{ route('follow.destroy', $user->id) }}" method="POST" onsubmit="setTimeout(() => { const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('mobileMenuOffcanvas')); if(offcanvas) offcanvas.hide(); }, 100);"> @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light border w-100">Unfollow</button>
                            </form>
                            @else
                            <form action="{{ route('follow.store', $user->id) }}" method="POST" onsubmit="setTimeout(() => { const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('mobileMenuOffcanvas')); if(offcanvas) offcanvas.hide(); }, 100);"> @csrf
                                <button type="submit" class="btn btn-sm btn-primary w-100">Follow</button>
                            </form>
                            @endif
                        </div>
                        @endif
                    </li>
                    @endforeach
                    @endif

                    {{-- Pengaturan & Logout --}}
                    <li class="nav-item mt-3 pt-3" style="border-top: 1px solid var(--border-color);">
                        <div class="nav-link d-flex align-items-center" onclick="closeOffcanvasAndRedirect('{{ route('profile.edit', Auth::user()->id) }}')" style="cursor: pointer;">
                            <i class="fas fa-gear me-3"></i> <span>Settings</span>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link d-flex align-items-center text-danger" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" style="cursor: pointer;">
                            <i class="fas fa-sign-out-alt me-3"></i> <span>Logout</span>
                        </div>
                        <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </li>
                    @else
                    {{-- Tautan Login/Register --}}
                    <li class="nav-item">
                        <div class="nav-link d-flex align-items-center" onclick="closeOffcanvasAndRedirect('{{ route('login') }}')" style="cursor: pointer;">
                            <i class="fas fa-sign-in-alt me-3"></i><span>Login</span>
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link d-flex align-items-center" onclick="closeOffcanvasAndRedirect('{{ route('register') }}')" style="cursor: pointer;">
                            <i class="fas fa-user-plus me-3"></i><span>Register</span>
                        </div>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>

        {{-- Kontainer Layout Utama --}}
        <div class="container-fluid main-content-area">
            <div class="row h-100">

                {{-- Sidebar Kiri (Desktop) --}}
                <aside class="col-md-3 col-lg-2 d-none d-md-flex flex-column sticky-sidebar left-sidebar">
                    {{-- Navigasi Utama Sidebar --}}
                    <ul class="nav flex-column sidebar-nav">
                        @auth
                        <li class="nav-item"><a class="nav-link {{ (request()->routeIs('posts.index') || request()->is('/')) ? 'active' : '' }}" href="{{ route('posts.index') }}"><i class="fas fa-home"></i>Home</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('search.index') ? 'active' : '' }}" href="{{ route('search.index') }}"><i class="fas fa-search"></i>Search</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('posts.create') ? 'active' : '' }}" href="{{ route('posts.create') }}"><i class="fas fa-plus-square"></i>New Post</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->is('profile*') ? 'active' : '' }}" href="{{ route('profile.show', Auth::user()->id) }}"><i class="fas fa-user-circle"></i>Profile</a></li>
                        @else
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i>Login</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}"><i class="fas fa-user-plus"></i>Register</a></li>
                        @endauth
                    </ul>

                    {{-- Tombol Logout Desktop --}}
                    @auth
                    <div class="logout-section">
                        <a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                            <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                        </a>
                        <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                    @endauth
                </aside>

                {{-- Area Konten Utama --}}
                <main class="col-12 col-md-9 col-lg-7 main-content">
                    @yield('content')
                </main>

                {{-- Sidebar Kanan (Desktop) --}}
                <aside class="col-lg-3 d-none d-lg-block sticky-sidebar right-sidebar">
                    @auth
                    {{-- Kartu Profil Pengguna --}}
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
                    {{-- Bagian Discover People --}}
                    <div class="sidebar-section">
                        <h6 class="sidebar-title">Discover People</h6>
                        @if(isset($randomUsersForSidebar) && $randomUsersForSidebar->count() > 0)
                        @foreach($randomUsersForSidebar as $user)
                        {{-- Item Pengguna --}}
                        <div class="user-item">
                            <a href="{{ route('profile.show', $user->id) }}"><img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/40' }}" class="user-avatar" style="width: 40px; height: 40px;" alt="{{ $user->username }}"></a>
                            <div class="user-info">
                                <a href="{{ route('profile.show', $user->id) }}" class="username">{{ Str::limit($user->username, 15) }}</a>
                                <div class="user-fullname">{{ Str::limit($user->name ?: 'New User', 20) }}</div>
                            </div>
                            @if(Auth::id() !== $user->id)
                            {{-- Tombol Follow/Unfollow --}}
                            <div class="ms-auto follow-btn-wrapper">
                                @if(Auth::user()->isFollowing($user))
                                <form action="{{ route('follow.destroy', $user->id) }}" method="POST"> @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light border w-100">Unfollow</button>
                                </form>
                                @else
                                <form action="{{ route('follow.store', $user->id) }}" method="POST"> @csrf
                                    <button type="submit" class="btn btn-sm btn-primary w-100">Follow</button>
                                </form>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                        @else
                        <p class="text-muted">No users to display.</p>
                        @endif
                    </div>
                    {{-- Footer Sidebar --}}
                    <footer class="footer-links mt-auto pt-3 border-top">
                        <p class="text-muted" style="font-size: 0.8rem;">&copy; {{ date('Y') }} REMBUG</p>
                    </footer>
                    @endauth
                </aside>
            </div>
        </div>
    </div>

    {{-- Navigasi Bawah Mobile --}}
    <nav class="mobile-bottom-nav d-block d-md-none">
        <ul class="nav-list">
            @auth
            {{-- Tautan Nav Mobile --}}
            <li class="nav-item">
                <a href="{{ route('posts.index') }}" class="nav-link {{ (request()->routeIs('posts.index') || request()->is('/')) ? 'active' : '' }}">
                    <i class="fas fa-home mobile-nav-icon icon-solid"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('search.index') }}" class="nav-link {{ request()->routeIs('search.index') ? 'active' : '' }}">
                    <i class="fas fa-search mobile-nav-icon icon-solid"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('posts.create') }}" class="nav-link {{ request()->routeIs('posts.create') ? 'active' : '' }}">
                    <i class="fas fa-plus-square mobile-nav-icon icon-solid"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.show', Auth::user()->id) }}" class="nav-link {{ request()->is('profile*') ? 'active' : '' }}">
                    @if (Auth::user()->profile_image)
                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile" class="mobile-nav-icon mobile-nav-profile-img">
                    @else
                    <i class="fas fa-user-circle mobile-nav-icon icon-solid"></i>
                    @endif
                </a>
            </li>
            @else
            {{-- Tautan Login/Register Mobile --}}
            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"><i class="fas fa-sign-in-alt mobile-nav-icon"></i></a></li>
            <li class="nav-item"><a href="{{ route('register') }}" class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}"><i class="fas fa-user-plus mobile-nav-icon"></i></a></li>
            @endauth
        </ul>
    </nav>

    {{-- Skrip JavaScript Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Skrip Kustom --}}
    <script>
        // Tutup Offcanvas & Redirect
        function closeOffcanvasAndRedirect(url) {
            const offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('mobileMenuOffcanvas'));
            if (offcanvas) {
                offcanvas.hide();
                setTimeout(() => {
                    window.location.href = url;
                }, 300);
            } else {
                window.location.href = url;
            }
        }
    </script>
</body>

</html>