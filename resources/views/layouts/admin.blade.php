<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'SavorNest')</title>
    
    <!-- Google Fonts: Inter & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        .admin-sidebar {
            min-height: calc(100vh - 76px);
            background-color: var(--sn-surface-soft);
            border-right: 1px solid var(--sn-border);
        }
        .admin-sidebar .nav-link {
            color: var(--sn-text-muted);
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 0.25rem;
            transition: all 0.2s ease;
        }
        .admin-sidebar .nav-link:hover, .admin-sidebar .nav-link.active {
            color: var(--sn-text-main);
            background-color: var(--sn-surface);
            box-shadow: var(--sn-shadow-sm);
        }
    </style>
    
    @yield('styles')
</head>
<body class="d-flex flex-column min-vh-100" style="background-color: var(--sn-bg);">

    <!-- Admin Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top py-3" style="background-color: var(--sn-surface); border-bottom: 1px solid var(--sn-border);">
        <div class="container-fluid px-4">
            <a class="navbar-brand editorial-font fw-bold" href="{{ route('admin.dashboard') }}">SavorNest Admin</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="adminNavbar">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item me-3">
                        <a class="nav-link text-muted-custom" href="{{ route('home') }}">View Site</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold text-dark" href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4 mt-2">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid flex-grow-1 d-flex p-0">
        <div class="row w-100 m-0">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-none d-md-block admin-sidebar p-3">
                <h6 class="text-uppercase text-muted-custom fw-bold mb-3 px-3 mt-3" style="font-size: 0.75rem; letter-spacing: 0.05em;">Management</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.recipes.*') ? 'active' : '' }}" href="{{ route('admin.recipes.index') }}">
                            Recipes
                        </a>
                    </li>
                    
                    <h6 class="text-uppercase text-muted-custom fw-bold mt-5 mb-3 px-3" style="font-size: 0.75rem; letter-spacing: 0.05em;">Master Data</h6>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                            Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.cuisines.*') ? 'active' : '' }}" href="{{ route('admin.cuisines.index') }}">
                            Cuisines
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.ingredients.*') ? 'active' : '' }}" href="{{ route('admin.ingredients.index') }}">
                            Ingredients
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10 p-4 p-md-5">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>
