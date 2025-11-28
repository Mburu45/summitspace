@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--background-dark); padding: 2rem;">
    <div style="background: var(--secondary-color); border-radius: 15px; padding: 3rem; box-shadow: var(--box-shadow); max-width: 400px; width: 100%;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h2 style="color: var(--accent-color); margin-bottom: 0.5rem;">Welcome Back</h2>
            <p style="color: var(--text-muted);">Sign in to your SummitSpace account</p>
        </div>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            {{-- Email --}}
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: var(--text-light); margin-bottom: 0.5rem; font-weight: 500;">Email Address</label>
                <input type="email" name="email"
                       style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 8px; background: var(--primary-color); color: var(--text-light); font-size: 1rem; transition: border-color 0.3s;"
                       value="{{ old('email') }}"
                       placeholder="Enter your email" required>
                @error('email')
                    <p style="color: var(--accent-orange); font-size: 0.9rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: var(--text-light); margin-bottom: 0.5rem; font-weight: 500;">Password</label>
                <input type="password" name="password"
                       style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 8px; background: var(--primary-color); color: var(--text-light); font-size: 1rem; transition: border-color 0.3s;"
                       placeholder="Enter your password" required>
                @error('password')
                    <p style="color: var(--accent-orange); font-size: 0.9rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Login Error --}}
            @if(session('error'))
                <div style="background: rgba(255, 107, 53, 0.1); border: 1px solid var(--accent-orange); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                    <p style="color: var(--accent-orange); margin: 0; font-size: 0.9rem;">{{ session('error') }}</p>
                </div>
            @endif

            <button type="submit" style="width: 100%; padding: 0.75rem; background: var(--accent-color); color: var(--secondary-color); border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-bottom: 1.5rem;">Sign In</button>

            <div style="text-align: center; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
                <a href="{{ route('password.request') }}" style="color: var(--accent-color); text-decoration: none; font-size: 0.9rem; margin-right: 1rem;">Forgot Password?</a>
                <span style="color: var(--text-muted);">|</span>
                <a href="{{ route('register') }}" style="color: var(--accent-purple); text-decoration: none; font-size: 0.9rem; margin-left: 1rem;">Create Account</a>
            </div>
        </form>
    </div>
</div>
@endsection
