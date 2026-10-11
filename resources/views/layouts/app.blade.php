<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SavorNest')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    @yield('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-savor sticky-top py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">SavorNest</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('recipes.index') }}">Explore</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-primary rounded-pill px-4" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        @if(Auth::user()->role === 'admin')
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary rounded-pill px-3" href="{{ route('admin.dashboard') }}">Admin</a>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.show', Auth::id()) }}">Public Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('my-recipes') }}">My Recipes</a></li>
                                <li><a class="dropdown-item" href="{{ route('recipes.create') }}">Create Recipe</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        <div class="container my-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="footer-savor mt-auto">
        <div class="container">
            <div class="row text-center text-md-start pb-4">
                <div class="col-md-5 mb-4 mb-md-0">
                    <h4 class="editorial-font mb-3">SavorNest</h4>
                    <p class="mb-0 text-muted-custom pe-md-4">Discover, share, and manage your favorite recipes with a passionate community of food lovers.</p>
                </div>
                <div class="col-md-3 mb-4 mb-md-0 text-center text-md-start">
                    <h6 class="mb-3 text-uppercase" style="letter-spacing: 0.05em; font-size: 0.85rem;">Explore</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('recipes.index') }}">All Recipes</a></li>
                        <li class="mb-2"><a href="{{ route('recipes.index', ['sort' => 'popular']) }}">Popular Recipes</a></li>
                    </ul>
                </div>
                <div class="col-md-4 text-center text-md-start">
                    <h6 class="mb-3 text-uppercase" style="letter-spacing: 0.05em; font-size: 0.85rem;">Account</h6>
                    <ul class="list-unstyled">
                        @guest
                            <li class="mb-2"><a href="{{ route('login') }}">Login</a></li>
                            <li class="mb-2"><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="mb-2"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="mb-2"><a href="{{ route('recipes.create') }}">Share a Recipe</a></li>
                        @endguest
                    </ul>
                </div>
            </div>
            <hr class="mt-2 mb-4" style="opacity: 0.1;">
            <div class="text-center text-muted-custom small">
                &copy; {{ date('Y') }} SavorNest. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>
