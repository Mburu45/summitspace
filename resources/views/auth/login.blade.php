@extends('layouts.app')

@section('content')
<div class="login-container">
    <form action="{{ route('login.store') }}" method="POST" class="login-form">
        @csrf

        <h2>Login</h2>

        {{-- Email --}}
        <div class="form-group">
            <input type="email" name="email" class="form-input"
                   value="{{ old('email') }}"
                   placeholder="Email" required>
            @error('email')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="form-group">
            <input type="password" name="password" class="form-input"
                   placeholder="Password" required>
            @error('password')
                <p class="error-text">{{ $message }}</p>
            @enderror
        </div>

        {{-- Login Error --}}
        @if(session('error'))
            <p class="error-text">{{ session('error') }}</p>
        @endif

        <button type="submit" class="login-btn">Login</button>

        <div class="form-footer">
            <a href="#" class="forgot-link">Forgot Password?</a>
            <p>Don't have an account? 
                <a href="{{ route('register') }}" class="register-link">Register</a>
            </p>
        </div>
    </form>
</div>
@endsection
