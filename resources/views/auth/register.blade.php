@extends('layouts.app')

@section('content')
<div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: var(--background-dark); padding: 2rem;">
    <div style="background: var(--secondary-color); border-radius: 15px; padding: 3rem; box-shadow: var(--box-shadow); max-width: 450px; width: 100%;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <h1 style="color: var(--accent-color); margin-bottom: 0.5rem; font-size: 2rem;">Join SummitSpace</h1>
            <p style="color: var(--text-muted);">Create your account and start exploring amazing events</p>
        </div>

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            {{-- Name --}}
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: var(--text-light); margin-bottom: 0.5rem; font-weight: 500;">Full Name</label>
                <div style="position: relative;">
                    <input type="text" name="name"
                           style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 3rem; border: 2px solid var(--border-color); border-radius: 8px; background: var(--primary-color); color: var(--text-light); font-size: 1rem; transition: border-color 0.3s;"
                           placeholder="Enter your full name"
                           value="{{ old('name') }}" required>
                    <span style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); font-size: 1.2rem;">👤</span>
                </div>
                @error('name')
                    <p style="color: var(--accent-orange); font-size: 0.9rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: var(--text-light); margin-bottom: 0.5rem; font-weight: 500;">Email Address</label>
                <div style="position: relative;">
                    <input type="email" name="email"
                           style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 3rem; border: 2px solid var(--border-color); border-radius: 8px; background: var(--primary-color); color: var(--text-light); font-size: 1rem; transition: border-color 0.3s;"
                           placeholder="Enter your email"
                           value="{{ old('email') }}" required>
                    <span style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); font-size: 1.2rem;">📧</span>
                </div>
                @error('email')
                    <p style="color: var(--accent-orange); font-size: 0.9rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: var(--text-light); margin-bottom: 0.5rem; font-weight: 500;">Password</label>
                <div style="position: relative;">
                    <input type="password" name="password"
                           style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 3rem; border: 2px solid var(--border-color); border-radius: 8px; background: var(--primary-color); color: var(--text-light); font-size: 1rem; transition: border-color 0.3s;"
                           placeholder="Create a strong password" required>
                    <span style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); font-size: 1.2rem;">🔒</span>
                </div>
                @error('password')
                    <p style="color: var(--accent-orange); font-size: 0.9rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: var(--text-light); margin-bottom: 0.5rem; font-weight: 500;">Confirm Password</label>
                <div style="position: relative;">
                    <input type="password" name="password_confirmation"
                           style="width: 100%; padding: 0.75rem 0.75rem 0.75rem 3rem; border: 2px solid var(--border-color); border-radius: 8px; background: var(--primary-color); color: var(--text-light); font-size: 1rem; transition: border-color 0.3s;"
                           placeholder="Confirm your password" required>
                    <span style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); font-size: 1.2rem;">🔐</span>
                </div>
                @error('password_confirmation')
                    <p style="color: var(--accent-orange); font-size: 0.9rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Role --}}
            <div style="margin-bottom: 2rem;">
                <label style="display: block; color: var(--text-light); margin-bottom: 0.5rem; font-weight: 500;">Account Type</label>
                <select name="role"
                        style="width: 100%; padding: 0.75rem; border: 2px solid var(--border-color); border-radius: 8px; background: var(--primary-color); color: var(--text-light); font-size: 1rem; transition: border-color 0.3s;">
                    <option value="user">🎭 Attendee</option>
                    <option value="employee">👔 Employee</option>
                    <option value="admin">⚡ Administrator</option>
                </select>
            </div>

            {{-- ERROR MESSAGE --}}
            @if ($errors->any())
                <div style="background: rgba(255, 107, 53, 0.1); border: 1px solid var(--accent-orange); border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                    <p style="color: var(--accent-orange); margin: 0; font-size: 0.9rem;">{{ $errors->first() }}</p>
                </div>
            @endif

            <button type="submit" style="width: 100%; padding: 0.75rem; background: var(--accent-color); color: var(--secondary-color); border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s; margin-bottom: 1.5rem;">Create Account</button>
        </form>

        <div style="text-align: center; border-top: 1px solid var(--border-color); padding-top: 1.5rem;">
            <p style="color: var(--text-muted); margin: 0;">
                Already have an account?
                <a href="{{ route('login') }}" style="color: var(--accent-purple); text-decoration: none; font-weight: 500; margin-left: 0.5rem;">Sign In</a>
            </p>
        </div>
    </div>
</div>
@endsection
