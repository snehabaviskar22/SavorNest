@extends('layouts.app')

@section('title', 'Explore Recipes | SavorNest')

@section('content')

<!-- Header Section -->
<div class="text-center pt-5 pb-4 mb-4">
    <h1 class="editorial-font display-4 mb-3">Explore Recipes</h1>
    <p class="text-muted-custom lead mx-auto" style="max-width: 600px;">Find your next culinary adventure. Filter by cuisine, category, or search for something specific.</p>
</div>

<!-- Horizontal Filter Bar -->
<div class="bg-surface rounded-5 p-4 mb-huge shadow-sm border border-light">
    <form action="{{ route('recipes.index') }}" method="GET" class="row g-3 align-items-end">
        
        <!-- Search -->
        <div class="col-12 col-md-4">
            <label class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Search</label>
            <input type="search" name="search" class="form-control" placeholder="Search recipes..." value="{{ request('search') }}">
        </div>
        
        <!-- Category -->
        <div class="col-6 col-md-2">
            <label class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Category</label>
            <select class="form-select" name="category" onchange="this.form.submit()">
                <option value="">All</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <!-- Cuisine -->
        <div class="col-6 col-md-2">
            <label class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Cuisine</label>
            <select class="form-select" name="cuisine" onchange="this.form.submit()">
                <option value="">All</option>
                @foreach($cuisines as $cuisine)
                    <option value="{{ $cuisine->id }}" {{ request('cuisine') == $cuisine->id ? 'selected' : '' }}>
                        {{ $cuisine->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <!-- Food Type -->
        <div class="col-6 col-md-2">
            <label class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Type</label>
            <select class="form-select" name="food_type" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="Vegetarian" {{ request('food_type') == 'Vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                <option value="Non-Vegetarian" {{ request('food_type') == 'Non-Vegetarian' ? 'selected' : '' }}>Non-Vegetarian</option>
                <option value="Vegan" {{ request('food_type') == 'Vegan' ? 'selected' : '' }}>Vegan</option>
            </select>
        </div>
        
        <!-- Sort -->
        <div class="col-6 col-md-2">
            <label class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Sort</label>
            <select class="form-select" name="sort" onchange="this.form.submit()">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Liked</option>
            </select>
        </div>
        
        <!-- Submit is hidden because onchange submits, but we need a submit button for the search input if they hit enter or click it, or we can just rely on the search input's native enter behavior. Let's add a visual submit just in case, but keep it minimal. Or a clear button. -->
        <div class="col-12 mt-4 text-center d-md-none">
            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
        </div>
    </form>
    
    @if(request()->anyFilled(['search', 'category', 'cuisine', 'food_type']) || request('sort') == 'popular')
    <div class="mt-3 text-center text-md-end">
        <a href="{{ route('recipes.index') }}" class="text-muted-custom text-decoration-none small">Clear All Filters &times;</a>
    </div>
    @endif
</div>

<!-- Recipe Grid -->
<div>
    @if(request('search'))
        <div class="mb-5 text-center">
            <h5 class="editorial-font text-muted-custom">Search results for <span class="text-dark fw-bold">"{{ request('search') }}"</span></h5>
        </div>
    @endif
    
    @if($recipes->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-5">
            @foreach($recipes as $recipe)
            <div class="col">
                <div class="card recipe-card h-100">
                    <a href="{{ route('recipes.show', $recipe) }}" class="text-decoration-none">
                        <div class="position-relative overflow-hidden" style="border-radius: 16px 16px 0 0;">
                            <img src="{{ $recipe->image ? asset('storage/' . $recipe->image) : 'https://placehold.co/600x400/F7F5F1/171717?text=Recipe' }}" class="card-img-top" alt="{{ $recipe->name }}">
                            @if($recipe->food_type)
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-white text-dark shadow-sm rounded-pill px-3 py-2 fw-medium border" style="font-size: 0.75rem;">{{ $recipe->food_type }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-uppercase fw-bold text-muted-custom" style="font-size: 0.75rem; letter-spacing: 0.05em;">{{ $recipe->category->name }}</span>
                                <div class="text-muted small d-flex align-items-center">
                                    <span class="text-danger me-1">&hearts;</span> {{ $recipe->likes_count }}
                                </div>
                            </div>
                            <h4 class="editorial-font text-dark mb-2" style="color: var(--sn-text-main);">{{ $recipe->name }}</h4>
                            <p class="text-muted-custom small mb-4 flex-grow-1">{{ Str::limit($recipe->description, 90) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top" style="border-color: var(--sn-border) !important;">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-secondary me-2 overflow-hidden" style="width: 28px; height: 28px;">
                                        <img src="{{ $recipe->user->profile_image ? asset('storage/' . $recipe->user->profile_image) : 'https://placehold.co/100x100/F4ECE1/171717?text=' . substr($recipe->user->name,0,1) }}" class="w-100 h-100" style="object-fit: cover;">
                                    </div>
                                    <small class="text-muted-custom fw-medium">{{ $recipe->user->name }}</small>
                                </div>
                                <small class="text-muted-custom">{{ $recipe->cuisine->name }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center mt-huge">
            {{ $recipes->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="text-center py-huge">
            <h3 class="editorial-font text-muted mb-4">No recipes found</h3>
            <p class="text-muted-custom mb-4">Try adjusting your search or filters to find what you're looking for.</p>
            <a href="{{ route('recipes.index') }}" class="btn btn-outline-primary btn-lg">Clear Filters</a>
        </div>
    @endif
</div>
@endsection
