@extends('layouts.app')

@section('title', 'Publish a Recipe | SavorNest')

@section('content')
<div class="row justify-content-center mb-huge">
    <div class="col-lg-9">
        
        <div class="text-center mb-5 pb-4 border-bottom border-light">
            <h1 class="editorial-font display-4 text-dark mb-3">Publish a Recipe</h1>
            <p class="text-muted-custom lead mx-auto" style="max-width: 600px;">Share your culinary secrets with the SavorNest community.</p>
        </div>

        <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data" id="recipeForm">
            @csrf
            
            <!-- 1. Basic Info -->
            <div class="bg-surface rounded-5 p-4 p-md-5 mb-5 shadow-sm border border-light">
                <h3 class="editorial-font mb-4 pb-3 border-bottom border-light">1. The Basics</h3>
                
                <div class="row g-4">
                    <div class="col-md-12">
                        <label for="name" class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Recipe Name *</label>
                        <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Classic Blueberry Pancakes" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="category_id" class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Category *</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="cuisine_id" class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Cuisine *</label>
                        <select class="form-select @error('cuisine_id') is-invalid @enderror" id="cuisine_id" name="cuisine_id" required>
                            <option value="">Select Cuisine</option>
                            @foreach($cuisines as $cuisine)
                                <option value="{{ $cuisine->id }}" {{ old('cuisine_id') == $cuisine->id ? 'selected' : '' }}>{{ $cuisine->name }}</option>
                            @endforeach
                        </select>
                        @error('cuisine_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label for="food_type" class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Food Type *</label>
                        <select class="form-select @error('food_type') is-invalid @enderror" id="food_type" name="food_type" required>
                            <option value="">Select Type</option>
                            <option value="Vegetarian" {{ old('food_type') == 'Vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                            <option value="Non-Vegetarian" {{ old('food_type') == 'Non-Vegetarian' ? 'selected' : '' }}>Non-Vegetarian</option>
                            <option value="Vegan" {{ old('food_type') == 'Vegan' ? 'selected' : '' }}>Vegan</option>
                        </select>
                        @error('food_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-12">
                        <label for="description" class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Share a little story or some tips about this recipe..." required>{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-md-12">
                        <label for="image" class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Recipe Photo *</label>
                        <div class="border rounded-4 p-4 text-center bg-light" style="border-style: dashed !important; border-width: 2px !important;">
                            <input type="file" class="form-control mb-3 @error('image') is-invalid @enderror" id="image" name="image" accept="image/jpeg, image/png, image/webp" onchange="previewImage(this)" required>
                            <div class="text-muted-custom small">Supported formats: JPG, PNG, WEBP.</div>
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            
                            <div class="mt-4 d-none" id="imagePreviewContainer">
                                <img id="imagePreview" src="#" alt="Preview" class="rounded-4 shadow-sm" style="max-height: 400px; width: 100%; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 2. Ingredients -->
            <div class="bg-surface rounded-5 p-4 p-md-5 mb-5 shadow-sm border border-light">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light">
                    <h3 class="editorial-font mb-0">2. Ingredients</h3>
                    <button type="button" class="btn btn-outline-primary btn-sm px-3" onclick="addIngredientRow()">+ Add Row</button>
                </div>
                
                <div id="ingredientsContainer">
                    <!-- Ingredient rows will be appended here -->
                </div>
                @error('ingredients')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- 3. Preparation -->
            <div class="bg-surface rounded-5 p-4 p-md-5 mb-5 shadow-sm border border-light">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light">
                    <h3 class="editorial-font mb-0">3. Preparation</h3>
                    <button type="button" class="btn btn-outline-primary btn-sm px-3" onclick="addStepRow()">+ Add Step</button>
                </div>
                
                <div id="stepsContainer">
                    <!-- Step rows will be appended here -->
                </div>
                @error('steps')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Submit -->
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('my-recipes') }}" class="btn btn-link text-muted-custom text-decoration-none">Cancel</a>
                <button type="submit" class="btn btn-primary btn-lg px-5 py-3 shadow-sm text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Publish Recipe</button>
            </div>
        </form>
    </div>
</div>

<!-- Templates for JS -->
<template id="ingredientTemplate">
    <div class="row g-3 align-items-end ingredient-row pb-3 mb-3 border-bottom border-light">
        <div class="col-md-5">
            <label class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Ingredient</label>
            <input type="text" class="form-control" name="ingredients[INDEX][name]" placeholder="e.g. All-purpose flour" required>
        </div>
        <div class="col-md-3">
            <label class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Quantity</label>
            <input type="number" step="0.1" min="0.1" class="form-control" name="ingredients[INDEX][quantity]" placeholder="e.g. 2" required>
        </div>
        <div class="col-md-3">
            <label class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Unit</label>
            <input type="text" class="form-control" name="ingredients[INDEX][unit]" placeholder="e.g. cups, tbsp" required>
        </div>
        <div class="col-md-1 text-end">
            <button type="button" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" style="width: 32px; height: 32px; padding: 0;" onclick="this.closest('.ingredient-row').remove()">&times;</button>
        </div>
    </div>
</template>

<template id="stepTemplate">
    <div class="step-row d-flex flex-column flex-md-row gap-4 mb-4 pb-4 border-bottom border-light align-items-start">
        <div class="flex-shrink-0 pt-2">
            <div class="step-number text-muted-custom fs-3" style="opacity: 0.3; line-height: 1;">
                INDEX_PAD
            </div>
        </div>
        <div class="flex-grow-1 w-100">
            <textarea class="form-control" name="steps[INDEX]" rows="3" placeholder="Describe this step in detail..." required></textarea>
        </div>
        <div class="flex-shrink-0 pt-2 text-end">
            <button type="button" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" style="width: 32px; height: 32px; padding: 0;" onclick="removeStepRow(this)">&times;</button>
        </div>
    </div>
</template>

@endsection

@section('scripts')
<script>
    let ingredientIndex = 0;
    let stepIndex = 0;
    
    const ingredientTemplate = document.getElementById('ingredientTemplate').innerHTML;
    const stepTemplate = document.getElementById('stepTemplate').innerHTML;
    const ingredientsContainer = document.getElementById('ingredientsContainer');
    const stepsContainer = document.getElementById('stepsContainer');

    function addIngredientRow() {
        const html = ingredientTemplate.replace(/INDEX/g, ingredientIndex);
        ingredientsContainer.insertAdjacentHTML('beforeend', html);
        ingredientIndex++;
    }

    function addStepRow() {
        const padIndex = String(stepIndex + 1).padStart(2, '0');
        const html = stepTemplate.replace(/INDEX_PAD/g, padIndex).replace(/INDEX/g, stepIndex);
        stepsContainer.insertAdjacentHTML('beforeend', html);
        stepIndex++;
        updateStepNumbers();
    }
    
    function removeStepRow(btn) {
        btn.closest('.step-row').remove();
        updateStepNumbers();
    }
    
    function updateStepNumbers() {
        const rows = stepsContainer.querySelectorAll('.step-row');
        rows.forEach((row, idx) => {
            const padIndex = String(idx + 1).padStart(2, '0');
            row.querySelector('.step-number').textContent = padIndex;
            row.querySelector('textarea').name = `steps[${idx}]`;
        });
        stepIndex = rows.length;
    }

    function previewImage(input) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImage = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.classList.add('d-none');
        }
    }

    // Add initial rows
    document.addEventListener('DOMContentLoaded', () => {
        addIngredientRow();
        addIngredientRow();
        addStepRow();
        addStepRow();
    });
</script>
@endsection
