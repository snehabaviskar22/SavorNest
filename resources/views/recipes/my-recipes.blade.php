@extends('layouts.app')

@section('title', 'My Recipes | SavorNest')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 pb-4 border-bottom border-light">
    <div>
        <h1 class="editorial-font display-5 text-dark mb-2">My Recipes</h1>
        <p class="text-muted-custom lead mb-0">Manage all the recipes you've published.</p>
    </div>
    <div class="mt-4 mt-md-0">
        <a href="{{ route('recipes.create') }}" class="btn btn-primary btn-lg shadow-sm">+ Publish New Recipe</a>
    </div>
</div>

<div class="bg-surface rounded-5 shadow-sm border border-light overflow-hidden mb-5">
    @if($recipes->count() > 0)
        <div class="table-responsive">
            <table class="table align-middle mb-0 border-0">
                <thead>
                    <tr>
                        <th class="text-muted-custom small text-uppercase fw-semibold border-0 ps-4 ps-md-5 py-4" style="letter-spacing: 0.05em; background-color: var(--sn-surface-soft);">Recipe</th>
                        <th class="text-muted-custom small text-uppercase fw-semibold border-0 py-4" style="letter-spacing: 0.05em; background-color: var(--sn-surface-soft);">Category & Cuisine</th>
                        <th class="text-muted-custom small text-uppercase fw-semibold border-0 py-4" style="letter-spacing: 0.05em; background-color: var(--sn-surface-soft);">Likes</th>
                        <th class="text-muted-custom small text-uppercase fw-semibold border-0 py-4" style="letter-spacing: 0.05em; background-color: var(--sn-surface-soft);">Date Published</th>
                        <th class="text-muted-custom small text-uppercase fw-semibold border-0 pe-4 pe-md-5 py-4 text-end" style="letter-spacing: 0.05em; background-color: var(--sn-surface-soft);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recipes as $recipe)
                    <tr>
                        <td class="ps-4 ps-md-5 py-4 border-light border-bottom">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 overflow-hidden shadow-sm flex-shrink-0" style="width: 64px; height: 64px;">
                                    <img src="{{ $recipe->image ? asset('storage/' . $recipe->image) : 'https://placehold.co/100x100/F7F5F1/171717?text=Img' }}" alt="{{ $recipe->name }}" class="w-100 h-100 object-fit-cover">
                                </div>
                                <div>
                                    <a href="{{ route('recipes.show', $recipe) }}" class="text-decoration-none fw-bold text-dark fs-6 d-block mb-1">{{ $recipe->name }}</a>
                                    @if($recipe->food_type)
                                        <span class="badge bg-light text-dark border fw-medium px-2 py-1" style="font-size: 0.7rem;">{{ $recipe->food_type }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="border-light border-bottom">
                            <div class="text-dark fw-medium mb-1">{{ $recipe->category->name }}</div>
                            <div class="text-muted-custom small">{{ $recipe->cuisine->name }}</div>
                        </td>
                        <td class="border-light border-bottom text-muted-custom">
                            <span class="text-danger me-1">&hearts;</span> {{ $recipe->likes_count }}
                        </td>
                        <td class="border-light border-bottom text-muted-custom small">
                            {{ $recipe->created_at->format('M d, Y') }}
                        </td>
                        <td class="text-end pe-4 pe-md-5 border-light border-bottom">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm rounded-pill px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Manage
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4 mt-2">
                                    <li><a class="dropdown-item py-2" href="{{ route('recipes.show', $recipe) }}">View Recipe</a></li>
                                    <li><a class="dropdown-item py-2" href="{{ route('recipes.edit', $recipe) }}">Edit Recipe</a></li>
                                    <li><hr class="dropdown-divider opacity-10"></li>
                                    <li>
                                        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Delete this recipe permanently? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger py-2">Delete Permanently</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-top border-light d-flex justify-content-center bg-surface-soft">
            {{ $recipes->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="card-body text-center py-huge">
            <h3 class="editorial-font text-dark mb-3">No recipes yet</h3>
            <p class="text-muted-custom mb-4 fs-5 mx-auto" style="max-width: 500px;">Start sharing your first culinary masterpiece with the SavorNest community.</p>
            <a href="{{ route('recipes.create') }}" class="btn btn-primary btn-lg rounded-pill px-5">Publish Your First Recipe</a>
        </div>
    @endif
</div>
@endsection
