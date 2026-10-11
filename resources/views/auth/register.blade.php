@extends('layouts.app')

@section('title', 'Register | SavorNest')

@section('content')
<div class="row justify-content-center mt-5 mb-huge">
    <div class="col-md-6 col-lg-5">
        <div class="bg-surface rounded-5 shadow-sm border border-light p-4 p-md-5">
            <div class="text-center mb-5">
                <h2 class="editorial-font text-dark mb-3">Join SavorNest</h2>
                <p class="text-muted-custom">Create an account to share and save recipes.</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="mb-4">
                    <label for="name" class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Full Name</label>
                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="email" class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Email Address</label>
                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="password" class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Password</label>
                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-5">
                    <label for="password_confirmation" class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Confirm Password</label>
                    <input type="password" class="form-control form-control-lg" id="password_confirmation" name="password_confirmation" required>
                </div>
                
                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary btn-lg py-3 shadow-sm text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Create Account</button>
                </div>
            </form>
            
            <div class="text-center">
                <span class="text-muted-custom">Already have an account?</span>
                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold text-dark ms-1">Login</a>
            </div>
        </div>
    </div>
</div>
@endsection
