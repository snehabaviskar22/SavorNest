@extends('layouts.admin')

@section('title', 'Add Ingredient')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Add Ingredient</h2>
    <a href="{{ route('admin.ingredients.index') }}" class="btn btn-outline-secondary rounded-pill">Back to Ingredients</a>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.ingredients.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label fw-medium">Ingredient Name *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary rounded-pill">Create Ingredient</button>
            </div>
        </form>
    </div>
</div>
@endsection
