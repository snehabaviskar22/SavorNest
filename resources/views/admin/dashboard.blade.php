@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold">Platform Overview</h2>
    <p class="text-muted">Welcome to the SavorNest administration panel.</p>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-primary text-white" style="background-color: var(--sn-primary-dark) !important;">
            <div class="card-body p-4 text-center">
                <h2 class="display-5 fw-bold mb-0">{{ $stats['users'] }}</h2>
                <div class="small text-uppercase tracking-wide mt-2 opacity-75">Users</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-info text-white" style="background-color: var(--sn-secondary-dark) !important;">
            <div class="card-body p-4 text-center">
                <h2 class="display-5 fw-bold mb-0">{{ $stats['recipes'] }}</h2>
                <div class="small text-uppercase tracking-wide mt-2 opacity-75">Recipes</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4 text-center">
                <h2 class="display-5 fw-bold mb-0 text-dark">{{ $stats['categories'] }}</h2>
                <div class="small text-uppercase tracking-wide mt-2 text-muted">Categories</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4 text-center">
                <h2 class="display-5 fw-bold mb-0 text-dark">{{ $stats['cuisines'] }}</h2>
                <div class="small text-uppercase tracking-wide mt-2 text-muted">Cuisines</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4 text-center">
                <h2 class="display-5 fw-bold mb-0 text-dark">{{ $stats['ingredients'] }}</h2>
                <div class="small text-uppercase tracking-wide mt-2 text-muted">Ingredients</div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card border-0 shadow-sm rounded-4 h-100 text-white" style="background-color: #e25555;">
            <div class="card-body p-4 text-center">
                <h2 class="display-5 fw-bold mb-0">{{ $stats['banned_users'] }}</h2>
                <div class="small text-uppercase tracking-wide mt-2 opacity-75">Banned</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center" style="background-color: var(--sn-warm-surface);">
            <h4 class="fw-bold mb-3" style="color: var(--sn-primary-dark)">Ready to manage the platform?</h4>
            <p class="text-muted mb-4">Use the sidebar navigation to moderate recipes, manage users, and update master data.</p>
            <div>
                <a href="{{ route('admin.recipes.index') }}" class="btn btn-primary rounded-pill px-4 me-2">Moderate Recipes</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary rounded-pill px-4">Manage Users</a>
            </div>
        </div>
    </div>
</div>
@endsection
