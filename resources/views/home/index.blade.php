@extends('layouts.app')

@section('content')

<div class="row align-items-center mb-huge pt-4">
    <div class="col-lg-5 pe-lg-5 mb-5 mb-lg-0">
        <h1 class="editorial-font display-3 fw-bold mb-4" style="line-height: 1.1;">Discover recipes worth making.</h1>
        <p class="lead text-muted-custom mb-5">Explore delicious recipes shared by a community of food lovers. Your next favorite meal is just a search away.</p>
        <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('recipes.index') }}" class="btn btn-primary btn-lg">Explore Recipes</a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Share Your Recipe</a>
            @else
                <a href="{{ route('recipes.create') }}" class="btn btn-outline-primary btn-lg">Share Your Recipe</a>
            @endguest
        </div>
    </div>
    <div class="col-lg-7">
        <div class="position-relative">
            <img src="{{ asset('storage/homeimgs/indian food.jpg') }}" alt="Delicious Food" class="img-fluid img-cover-rounded shadow-sm" style="height: 600px;">
            <div class="position-absolute bg-soft rounded-circle" style="width: 150px; height: 150px; bottom: -30px; left: -30px; z-index: -1;"></div>
        </div>
    </div>
</div>

@php
    $categoryImages = [
        'Breakfast' => 'homeimgs/categories/breakfast.jpg',
        'Lunch' => 'homeimgs/categories/lunch.jpg',
        'Dinner' => 'homeimgs/categories/dinner.jpg',
        'Desserts' => 'homeimgs/categories/dessert.jpg',
        'Snacks' => 'homeimgs/categories/snacks.jpg',
        'Beverages' => 'homeimgs/categories/beverages.jpg',
    ];
@endphp

@if($categories->count() > 0)
<div class="mb-huge">
    <div class="d-flex justify-content-between align-items-end mb-5">
        <h2 class="editorial-font mb-0">Browse by Category</h2>
    </div>

    <div class="row row-cols-3 row-cols-md-6 g-4 text-center">
        @foreach($categories as $index => $category)

        <div class="col">
            <a href="{{ route('categories.show', $category) }}"
               class="text-decoration-none text-dark group-hover">

                <div class="rounded-circle overflow-hidden mx-auto mb-3 shadow-sm border border-light"
                     style="width: 120px; height: 120px; transition: transform 0.3s ease;">

                    <img src="{{ asset('storage/' . ($categoryImages[$category->name] ?? 'homeimgs/categories/dessert.jpg')) }}"
                         alt="{{ $category->name }}"
                         style="width: 100%; height: 100%; object-fit: cover;">

                </div>

                <h6 class="fw-semibold text-muted-custom">
                    {{ $category->name }}
                </h6>

            </a>
        </div>

        @endforeach
    </div>
</div>
@endif

@if($featuredRecipes->count() > 0)
<div class="mb-huge">
    <div class="d-flex justify-content-between align-items-end mb-5">
        <h2 class="editorial-font mb-0">Super Delicious</h2>
        <a href="{{ route('recipes.index', ['sort' => 'popular']) }}" class="text-decoration-none fw-medium text-muted-custom hover-dark">View All &rarr;</a>
    </div>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-5">
        @foreach($featuredRecipes as $recipe)
        <div class="col">
            <div class="card recipe-card h-100">
                <a href="{{ route('recipes.show', $recipe) }}" class="text-decoration-none">
                    <div class="position-relative overflow-hidden" style="border-radius: 16px 16px 0 0;">
                        <img src="{{ $recipe->image ? asset('storage/' . $recipe->image) : 'https://placehold.co/600x400/F7F5F1/171717?text=Recipe' }}" class="card-img-top" alt="{{ $recipe->name }}">
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-uppercase fw-bold text-muted-custom" style="font-size: 0.75rem; letter-spacing: 0.05em;">{{ $recipe->category->name }}</span>
                            <div class="text-muted small d-flex align-items-center">
                                <span class="text-danger me-1">&hearts;</span> {{ $recipe->likes_count }}
                            </div>
                        </div>
                        <h4 class="editorial-font text-dark mb-2" style="color: var(--sn-text-main);">{{ $recipe->name }}</h4>
                        <div class="d-flex justify-content-between align-items-center mt-auto pt-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-secondary me-2 overflow-hidden" style="width: 28px; height: 28px;">
                                    <img src="{{ $recipe->user->profile_image ? asset('storage/' . $recipe->user->profile_image) : 'https://placehold.co/100x100/F4ECE1/171717?text=' . substr($recipe->user->name,0,1) }}" class="w-100 h-100" style="object-fit: cover;">
                                </div>
                                <small class="text-muted-custom fw-medium">{{ $recipe->user->name }}</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="bg-soft rounded-5 p-5 text-center my-5 shadow-sm">
    <div class="py-5 mx-auto" style="max-width: 600px;">
        <h2 class="editorial-font display-5 mb-4">Got a recipe to share?</h2>
        <p class="text-muted-custom mb-5 fs-5">Join our community and share your culinary creations with food lovers worldwide.</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">Join SavorNest</a>
        @else
            <a href="{{ route('recipes.create') }}" class="btn btn-primary btn-lg px-5">Publish a Recipe</a>
        @endguest
    </div>
</div>

@endsection

@section('styles')
<style>
    .group-hover:hover .rounded-circle {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0,0,0,0.1) !important;
    }
    .hover-dark:hover {
        color: var(--sn-text-main) !important;
    }
</style>
@endsection
