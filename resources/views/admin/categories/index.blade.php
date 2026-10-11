@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Manage Categories</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary rounded-pill">Add Category</a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Recipes</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @foreach($categories as $category)
                <tr>
                    <td class="ps-4 py-3">{{ $category->id }}</td>
                    <td class="fw-bold">{{ $category->name }}</td>
                    <td class="text-muted text-truncate" style="max-width: 300px;">{{ $category->description ?? '-' }}</td>
                    <td><span class="badge bg-secondary rounded-pill">{{ $category->recipes_count }}</span></td>
                    <td class="text-end pe-4">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary rounded-pill me-1">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?');">
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
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
