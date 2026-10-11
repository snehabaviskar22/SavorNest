@extends('layouts.app')

@section('title', $user->name . ' - Profile | SavorNest')

@section('content')
<div class="row justify-content-center mb-huge">
    <div class="col-lg-10">
        
        <div class="bg-surface rounded-5 shadow-sm border border-light overflow-hidden mb-huge">
            <div class="bg-soft" style="height: 200px;"></div>
            <div class="px-4 px-md-5 pb-5 position-relative">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end mt-n5 mb-4">
                    <div class="d-flex align-items-end mb-4 mb-sm-0 position-relative z-1">
                        <div class="rounded-circle border border-4 border-white overflow-hidden bg-white shadow-sm me-4" style="width: 140px; height: 140px; margin-top: -70px;">
                            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://placehold.co/200x200/F4ECE1/171717?text=' . substr($user->name,0,1) }}" class="w-100 h-100 object-fit-cover" alt="{{ $user->name }}">
                        </div>
                        <div class="mb-2">
                            <h2 class="editorial-font text-dark mb-1">{{ $user->name }}</h2>
                            <p class="text-muted-custom small text-uppercase fw-semibold mb-0" style="letter-spacing: 0.05em;">Member since {{ $user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                    @auth
                        @if(Auth::id() === $user->id)
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary px-4 mb-3">Edit Profile</a>
                        @endif
                    @endauth
                </div>
                
                <div class="row mt-5 pt-3 border-top border-light">
                    <div class="col-md-8 pe-md-5">
                        <h5 class="editorial-font mb-3">About {{ $user->name }}</h5>
                        <p class="text-muted-custom fs-5 lh-lg" style="font-weight: 300;">{{ $user->bio ?? 'This user has not written a bio yet.' }}</p>
                    </div>
                    <div class="col-md-4 mt-4 mt-md-0 d-flex justify-content-md-end gap-5">
                        <div class="text-center">
                            <h2 class="editorial-font text-dark mb-1">{{ $user->recipes()->count() }}</h2>
                            <div class="text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.1em;">Recipes</div>
                        </div>
                        <div class="text-center">
                            <h2 class="editorial-font text-dark mb-1 d-flex align-items-center justify-content-center gap-2">
                                <span class="text-danger fs-4 opacity-75">&hearts;</span> {{ $totalLikes }}
                            </h2>
                            <div class="text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.1em;">Likes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-5 pb-3 border-bottom border-light">
            <h3 class="editorial-font mb-0">Recipes by {{ $user->name }}</h3>
        </div>
        
        @if($recipes->count() > 0)
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-5 mb-5">
                @foreach($recipes as $recipe)
                <div class="col">
                    <div class="card recipe-card h-100">
                        <a href="{{ route('recipes.show', $recipe) }}" class="text-decoration-none">
                            <div class="position-relative overflow-hidden" style="border-radius: 16px 16px 0 0;">
                                <img src="{{ $recipe->image ? asset('storage/' . $recipe->image) : 'https://placehold.co/600x400/F7F5F1/171717?text=Recipe' }}" class="card-img-top" alt="{{ $recipe->name }}">
                                @if($recipe->food_type)
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-white text-dark shadow-sm rounded-pill px-3 py-2 fw-medium border" style="font-size: 0.75rem;">{{ $recipe->food_type }}</span>
                                </div>
                                @endif
                            </div>
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-uppercase fw-bold text-muted-custom" style="font-size: 0.75rem; letter-spacing: 0.05em;">{{ $recipe->category->name }}</span>
                                    <div class="text-muted small d-flex align-items-center">
                                        <span class="text-danger me-1">&hearts;</span> {{ $recipe->likes_count }}
                                    </div>
                                </div>
                                <h4 class="editorial-font text-dark mb-2" style="color: var(--sn-text-main);">{{ $recipe->name }}</h4>
                                <p class="text-muted-custom small mb-4 flex-grow-1">{{ Str::limit($recipe->description, 90) }}</p>
                                
                                <div class="d-flex justify-content-end align-items-center mt-auto pt-3 border-top border-light">
                                    <small class="text-muted-custom">{{ $recipe->cuisine->name }}</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="d-flex justify-content-center mt-5">
                {{ $recipes->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-huge bg-surface rounded-5 shadow-sm border border-light">
                <h3 class="editorial-font text-muted mb-3">{{ $user->name }} hasn't published any recipes yet.</h3>
                <p class="text-muted-custom">Check back later for culinary creations.</p>
            </div>
        @endif
    </div>
</div>
@endsection
