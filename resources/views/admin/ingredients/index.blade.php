@extends('layouts.admin')

@section('title', 'Manage Ingredients')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Manage Ingredients</h2>
    <a href="{{ route('admin.ingredients.create') }}" class="btn btn-primary rounded-pill">Add Ingredient</a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">ID</th>
                    <th>Name</th>
                    <th>Used in Recipes</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @foreach($ingredients as $ingredient)
                <tr>
                    <td class="ps-4 py-3">{{ $ingredient->id }}</td>
                    <td class="fw-bold">{{ $ingredient->name }}</td>
                    <td><span class="badge bg-secondary rounded-pill">{{ $ingredient->recipes_count }}</span></td>
                    <td class="text-end pe-4">
                        <a href="{{ route('admin.ingredients.edit', $ingredient) }}" class="btn btn-sm btn-outline-secondary rounded-pill me-1">Edit</a>
                        <form action="{{ route('admin.ingredients.destroy', $ingredient) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this ingredient?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-top d-flex justify-content-center">
        {{ $ingredients->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
