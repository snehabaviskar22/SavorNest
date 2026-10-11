@extends('layouts.app')

@section('title', $recipe->name . ' | SavorNest')

@section('content')
<!-- Recipe Image Hero -->
<div class="mb-5 position-relative">
    <div class="rounded-5 overflow-hidden shadow-sm" style="height: 60vh; min-height: 400px; max-height: 600px;">
        <img src="{{ $recipe->image ? asset('storage/' . $recipe->image) : 'https://placehold.co/1200x600/F7F5F1/171717?text=Recipe+Image' }}" alt="{{ $recipe->name }}" class="w-100 h-100" style="object-fit: cover;">
    </div>
</div>

<div class="row justify-content-center mb-huge">
    <div class="col-lg-10">
        
        <!-- Header & Meta -->
        <div class="text-center mb-5 pb-4 border-bottom border-light">
            <span class="text-uppercase fw-bold text-muted-custom mb-3 d-inline-block" style="letter-spacing: 0.1em; font-size: 0.85rem;">{{ $recipe->category->name }}</span>
            <h1 class="editorial-font display-3 text-dark mb-4" style="line-height: 1.1;">{{ $recipe->name }}</h1>
            
            <div class="d-flex justify-content-center align-items-center gap-4 text-muted-custom mb-4">
                <span class="d-flex align-items-center gap-2">
                    <img src="{{ $recipe->user->profile_image ? asset('storage/' . $recipe->user->profile_image) : 'https://placehold.co/100x100/F4ECE1/171717?text=' . substr($recipe->user->name,0,1) }}" class="rounded-circle object-fit-cover" style="width: 24px; height: 24px;">
                    <a href="{{ route('profile.show', $recipe->user) }}" class="text-decoration-none text-dark fw-medium">{{ $recipe->user->name }}</a>
                </span>
                <span>&bull;</span>
                <span>{{ $recipe->created_at->format('M d, Y') }}</span>
                <span>&bull;</span>
                <span class="fw-medium text-dark">{{ $recipe->cuisine->name }}</span>
                @if($recipe->food_type)
                <span>&bull;</span>
                <span class="fw-medium text-dark">{{ $recipe->food_type }}</span>
                @endif
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-center align-items-center gap-4">
                @auth
                    @if(Auth::id() !== $recipe->user_id)
                        @if($userLiked)
                            <form action="{{ route('likes.destroy', $recipe) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="like-btn d-flex align-items-center gap-2" title="Unlike">
                                    <span class="fs-4">&hearts;</span> <span class="fs-6 text-dark fw-medium">{{ $recipe->likes_count }}</span>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('likes.store', $recipe) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="like-btn unliked d-flex align-items-center gap-2" title="Like">
                                    <span class="fs-4">&hearts;</span> <span class="fs-6 text-dark fw-medium">{{ $recipe->likes_count }}</span>
                                </button>
                            </form>
                        @endif
                    @else
                        <div class="d-flex align-items-center gap-2">
                            <span class="fs-4 text-danger">&hearts;</span> <span class="fs-6 text-dark fw-medium">{{ $recipe->likes_count }}</span>
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-decoration-none like-btn unliked d-flex align-items-center gap-2">
                        <span class="fs-4">&hearts;</span> <span class="fs-6 text-dark fw-medium">{{ $recipe->likes_count }}</span>
                    </a>
                @endauth
                
                @auth
                    @if(Auth::id() === $recipe->user_id)
                        <div class="d-flex gap-2 ms-4 pl-4 border-start">
                            <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-outline-primary btn-sm px-3">Edit</a>
                            <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this recipe?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm px-3 border-0">Delete</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
        
        <!-- Description -->
        <div class="mb-huge text-center mx-auto" style="max-width: 800px;">
            <p class="fs-4 lh-lg text-dark" style="font-weight: 300;">
                {{ $recipe->description }}
            </p>
        </div>

        <!-- Recipe Content Split -->
        <div class="row g-lg-5">
            
            <!-- Ingredients Column -->
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="bg-soft p-4 p-lg-5 rounded-4 sticky-top" style="top: 100px;">
                    <h3 class="editorial-font mb-4 pb-3 border-bottom border-light">Ingredients</h3>
                    <ul class="list-unstyled mb-0">
                        @foreach($recipe->ingredients as $ingredient)
                            <li class="d-flex justify-content-between align-items-start py-3 border-bottom border-light" style="border-color: rgba(0,0,0,0.05) !important;">
                                <span class="fw-medium text-dark pe-3">{{ $ingredient->name }}</span>
                                <span class="text-muted-custom text-end flex-shrink-0">{{ rtrim(rtrim($ingredient->pivot->quantity, '0'), '.') }} {{ $ingredient->pivot->unit }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <!-- Preparation Column -->
            <div class="col-lg-8">
                <div class="ps-lg-4">
                    <h3 class="editorial-font mb-5 pb-3 border-bottom border-light">Preparation</h3>
                    
                    <div class="steps-container">
                        @foreach($recipe->preparationSteps as $index => $step)
                            <div class="d-flex flex-column flex-md-row gap-4 mb-5 pb-4">
                                <div class="flex-shrink-0">
                                    <div class="step-number text-muted-custom" style="opacity: 0.3; line-height: 1;">
                                        {{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <p class="fs-5 lh-lg mb-0 text-dark" style="font-weight: 400;">{{ $step->instruction }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Author Profile Footer -->
        <div class="mt-huge pt-5 border-top border-light text-center">
            <h4 class="editorial-font mb-4 text-muted-custom">Recipe by</h4>
            <div class="d-flex flex-column align-items-center">
                <div class="rounded-circle overflow-hidden mb-3 shadow-sm border border-white border-4" style="width: 120px; height: 120px;">
                    <img src="{{ $recipe->user->profile_image ? asset('storage/' . $recipe->user->profile_image) : 'https://placehold.co/200x200/F4ECE1/171717?text=' . substr($recipe->user->name,0,1) }}" class="w-100 h-100 object-fit-cover">
                </div>
                <h3 class="editorial-font text-dark mb-2">{{ $recipe->user->name }}</h3>
                <p class="text-muted-custom mb-4 mx-auto" style="max-width: 500px;">
                    {{ Str::limit($recipe->user->bio, 150) ?? 'Passionate food creator on SavorNest.' }}
                </p>
                <a href="{{ route('profile.show', $recipe->user) }}" class="btn btn-outline-primary px-4">View All Recipes</a>
            </div>
        </div>

    </div>
</div>
@endsection
