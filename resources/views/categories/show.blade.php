@extends('layouts.app')

@section('title', $category->name . ' Recipes | SavorNest')

@section('content')
<div class="text-center mb-5">
    <span class="badge badge-savor mb-3 px-3 py-2 fs-6">Category</span>
    <h1 class="display-4 fw-bold mb-3" style="color: var(--sn-primary-dark)">{{ $category->name }}</h1>
    @if($category->description)
        <p class="lead text-muted mx-auto" style="max-width: 600px;">{{ $category->description }}</p>
    @endif
</div>

@if($recipes->count() > 0)
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 mb-5">
        @foreach($recipes as $recipe)
        <div class="col">
            <div class="card h-100 recipe-card border-0 shadow-sm">
                <img src="{{ $recipe->image ? asset('storage/' . $recipe->image) : 'https://placehold.co/600x400/F1E9DE/3B2723?text=Recipe' }}" class="card-img-top" alt="{{ $recipe->name }}">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="text-muted small fw-medium">{{ $recipe->cuisine->name }}</div>
                        <div class="text-muted small">
                            &hearts; {{ $recipe->likes_count }}
                        </div>
                    </div>
                    <h5 class="card-title fw-bold">
                        <a href="{{ route('recipes.show', $recipe) }}" class="text-decoration-none" style="color: var(--sn-text)">{{ $recipe->name }}</a>
                    </h5>
                    
                    <div class="d-flex align-items-center mt-auto pt-3">
                        <div class="rounded-circle bg-secondary me-2 flex-shrink-0" style="width: 24px; height: 24px; background: url('{{ $recipe->user->profile_image ? asset('storage/' . $recipe->user->profile_image) : 'https://placehold.co/100x100/A47764/fff?text=' . substr($recipe->user->name,0,1) }}') center/cover;"></div>
                        <small class="text-muted text-truncate">{{ $recipe->user->name }}</small>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="d-flex justify-content-center mt-4">
        {{ $recipes->links('pagination::bootstrap-5') }}
    </div>
@else
    <div class="text-center py-5 bg-white rounded-4 shadow-sm my-5">
        <div class="display-1 text-muted opacity-25 mb-4">🍽️</div>
        <h3 class="fw-bold text-muted">No recipes found</h3>
        <p class="text-muted mb-4">There are no recipes in the {{ $category->name }} category yet.</p>
        <a href="{{ route('recipes.index') }}" class="btn btn-outline-primary rounded-pill px-4">Explore All Recipes</a>
    </div>
@endif
@endsection
