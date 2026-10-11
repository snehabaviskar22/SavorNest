@extends('layouts.app')

@section('title', 'Edit Profile | SavorNest')

@section('content')
<div class="row justify-content-center mb-huge">
    <div class="col-md-8 col-lg-6">
        
        <div class="text-center mb-5 pb-4 border-bottom border-light">
            <h1 class="editorial-font display-5 text-dark mb-3">Edit Profile</h1>
            <p class="text-muted-custom lead mx-auto">Update your personal details and bio.</p>
        </div>

        <div class="bg-surface rounded-5 shadow-sm border border-light p-4 p-md-5">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="text-center mb-5">
                    <div class="position-relative d-inline-block">
                        <img id="imagePreview" src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://placehold.co/200x200/F4ECE1/171717?text=' . substr($user->name,0,1) }}" class="rounded-circle border border-4 border-white shadow-sm object-fit-cover" style="width: 150px; height: 150px;" alt="Profile Preview">
                        <label for="profile_image" class="position-absolute bottom-0 end-0 rounded-circle shadow-sm d-flex justify-content-center align-items-center" style="cursor: pointer; background-color: var(--sn-surface); width: 40px; height: 40px; border: 1px solid var(--sn-border);">
                            <span style="font-size: 1.2rem;">📷</span>
                        </label>
                    </div>
                    <input type="file" class="d-none @error('profile_image') is-invalid @enderror" id="profile_image" name="profile_image" accept="image/jpeg, image/png, image/webp" onchange="previewImage(this)">
                    <div class="text-muted-custom small mt-3">Click icon to update photo</div>
                    @error('profile_image')<div class="invalid-feedback d-block mt-2">{{ $message }}</div>@enderror
                </div>
                
                <div class="mb-4">
                    <label for="name" class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Full Name *</label>
                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Email Address (Read Only)</label>
                    <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
                </div>
                
                <div class="mb-5">
                    <label for="bio" class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Bio</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="5" placeholder="Tell us about yourself and your cooking style...">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('profile.show', $user) }}" class="btn btn-link text-muted-custom text-decoration-none px-0">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-lg px-5 py-3 shadow-sm text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(input) {
        const previewImage = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
