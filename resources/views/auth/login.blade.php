@extends('layouts.app')

@section('title', 'Login | SavorNest')

@section('content')
<div class="row justify-content-center mt-5 mb-huge">
    <div class="col-md-6 col-lg-5">
        <div class="bg-surface rounded-5 shadow-sm border border-light p-4 p-md-5">
            <div class="text-center mb-5">
                <h2 class="editorial-font text-dark mb-3">Welcome Back</h2>
                <p class="text-muted-custom">Login to your SavorNest account</p>
            </div>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-4">
                    <label for="email" class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Email Address</label>
                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-5">
                    <label for="password" class="form-label text-muted-custom small text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Password</label>
                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary btn-lg py-3 shadow-sm text-uppercase fw-semibold" style="letter-spacing: 0.05em;">Login</button>
                </div>
            </form>
            
            <div class="text-center">
                <span class="text-muted-custom">Don't have an account?</span>
                <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-dark ms-1">Create one</a>
            </div>
        </div>
    </div>
</div>
@endsection
