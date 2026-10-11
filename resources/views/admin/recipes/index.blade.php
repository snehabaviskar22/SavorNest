@extends('layouts.admin')

@section('title', 'Moderate Recipes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Moderate Recipes</h2>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Recipe</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th>Likes</th>
                    <th>Date Published</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @foreach($recipes as $recipe)
                <tr>
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-center">
                            <img src="{{ $recipe->image ? asset('storage/' . $recipe->image) : 'https://placehold.co/100x100/F1E9DE/3B2723?text=Img' }}" alt="{{ $recipe->name }}" class="rounded me-3 object-fit-cover" style="width: 50px; height: 50px;">
                            <a href="{{ route('recipes.show', $recipe) }}" class="text-decoration-none fw-bold text-dark" target="_blank">{{ $recipe->name }}</a>
                        </div>
                    </td>
                    <td><a href="{{ route('profile.show', $recipe->user) }}" class="text-decoration-none text-muted" target="_blank">{{ $recipe->user->name }}</a></td>
                    <td>{{ $recipe->category->name }}</td>
                    <td><span class="badge bg-light text-dark border">{{ $recipe->food_type }}</span></td>
                    <td>&hearts; {{ $recipe->likes_count }}</td>
                    <td class="text-muted small">{{ $recipe->created_at->format('M d, Y') }}</td>
                    <td class="text-end pe-4">
                        <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-sm btn-outline-secondary rounded-pill me-1" target="_blank">View</a>
                        <form action="{{ route('admin.recipes.destroy', $recipe) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this recipe permanently? This is an admin action and cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-top d-flex justify-content-center">
        {{ $recipes->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
