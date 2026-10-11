@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Edit Category</h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary rounded-pill">Back to Categories</a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label fw-medium">Category Name *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label for="description" class="form-label fw-medium">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary rounded-pill">Update Category</button>
            </div>
        </form>
    </div>
</div>
@endsection
