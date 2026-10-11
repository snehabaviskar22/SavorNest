@extends('layouts.app')

@section('title', 'Dashboard | SavorNest')

@section('content')
<div class="row justify-content-center mb-huge">
    <div class="col-lg-10">
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 pb-4 border-bottom border-light">
            <div>
                <h1 class="editorial-font display-5 text-dark mb-2">Welcome back, {{ $user->name }}.</h1>
                <p class="text-muted-custom lead mb-0">Here is an overview of your SavorNest workspace.</p>
            </div>
            <div class="mt-4 mt-md-0">
                <a href="{{ route('recipes.create') }}" class="btn btn-primary btn-lg shadow-sm">+ Publish Recipe</a>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="bg-surface rounded-5 p-5 text-center shadow-sm border border-light h-100 d-flex flex-column justify-content-center align-items-center">
                    <h2 class="editorial-font text-dark mb-2" style="font-size: 4rem;">{{ $totalRecipes }}</h2>
                    <p class="text-muted-custom text-uppercase fw-semibold mb-0" style="letter-spacing: 0.1em; font-size: 0.85rem;">Published Recipes</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-surface rounded-5 p-5 text-center shadow-sm border border-light h-100 d-flex flex-column justify-content-center align-items-center">
                    <h2 class="editorial-font text-dark mb-2 d-flex align-items-center gap-3" style="font-size: 4rem;">
                        <span class="text-danger opacity-75">&hearts;</span> {{ $totalLikesReceived }}
                    </h2>
                    <p class="text-muted-custom text-uppercase fw-semibold mb-0" style="letter-spacing: 0.1em; font-size: 0.85rem;">Total Likes Received</p>
                </div>
            </div>
        </div>

        <div class="bg-surface rounded-5 shadow-sm border border-light overflow-hidden">
            <div class="p-4 p-md-5 d-flex justify-content-between align-items-center border-bottom border-light">
                <h4 class="editorial-font mb-0">Recent Recipes</h4>
                <a href="{{ route('my-recipes') }}" class="text-muted-custom text-decoration-none fw-medium hover-dark">View All &rarr;</a>
            </div>
            
            @if($recentRecipes->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle mb-0 border-0">
                        <thead>
                            <tr>
                                <th class="text-muted-custom small text-uppercase fw-semibold border-0 ps-4 ps-md-5 py-3" style="letter-spacing: 0.05em; background-color: var(--sn-surface-soft);">Recipe</th>
                                <th class="text-muted-custom small text-uppercase fw-semibold border-0 py-3" style="letter-spacing: 0.05em; background-color: var(--sn-surface-soft);">Category</th>
                                <th class="text-muted-custom small text-uppercase fw-semibold border-0 py-3" style="letter-spacing: 0.05em; background-color: var(--sn-surface-soft);">Likes</th>
                                <th class="text-muted-custom small text-uppercase fw-semibold border-0 pe-4 pe-md-5 py-3 text-end" style="letter-spacing: 0.05em; background-color: var(--sn-surface-soft);">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRecipes as $recipe)
                            <tr>
                                <td class="ps-4 ps-md-5 py-4 border-light border-bottom">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 overflow-hidden shadow-sm" style="width: 48px; height: 48px;">
                                            <img src="{{ $recipe->image ? asset('storage/' . $recipe->image) : 'https://placehold.co/100x100/F7F5F1/171717?text=Img' }}" alt="{{ $recipe->name }}" class="w-100 h-100 object-fit-cover">
                                        </div>
                                        <a href="{{ route('recipes.show', $recipe) }}" class="text-decoration-none fw-semibold text-dark">{{ $recipe->name }}</a>
                                    </div>
                                </td>
                                <td class="border-light border-bottom text-muted-custom">{{ $recipe->category->name }}</td>
                                <td class="border-light border-bottom text-muted-custom"><span class="text-danger me-1">&hearts;</span> {{ $recipe->likes_count }}</td>
                                <td class="text-end pe-4 pe-md-5 border-light border-bottom">
                                    <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-outline-primary btn-sm px-3">Edit</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-huge">
                    <p class="text-muted-custom mb-4 fs-5">You haven't published any recipes yet.</p>
                    <a href="{{ route('recipes.create') }}" class="btn btn-primary px-4">Create Your First Recipe</a>
                </div>
            @endif
        </div>

    </div>
</div>

@section('styles')
<style>
    .hover-dark:hover { color: var(--sn-text-main) !important; }
</style>
@endsection
@endsection
