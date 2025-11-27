@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Join SummitSpace</h1>
            <p>Create your account and start exploring amazing events</p>
        </div>

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <input 
                    type="text" 
                    class="input-field"
                    name="name"
                    placeholder="Full Name"
                    value="{{ old('name') }}"
                    required
                />
                <span class="input-icon">👤</span>
            </div>

            <div class="form-group">
                <input 
                    type="email" 
                    name="email"
                    class="input-field"
                    placeholder="Email Address"
                    value="{{ old('email') }}"
                    required
                />
                <span class="input-icon">📧</span>
            </div>

            <div class="form-group">
                <input 
                    type="password"
                    name="password"
                    class="input-field"
                    placeholder="Create Password"
                    required
                />
                <span class="input-icon">🔒</span>
            </div>

            <div class="form-group">
                <div class="role-select">
                    <select 
                        name="role" 
                        class="input-field"
                    >
                        <option value="user">Attendee</option>
                        <option value="organizer">Event Organizer</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
            </div>

            {{-- ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="error-message" style="color:red;margin-bottom:1rem;">
                    {{ $errors->first() }}
                </div>
            @endif

            <button type="submit" class="submit-btn">
                Create Account
            </button>
        </form>

        <div class="divider">
            <span>or</span>
        </div>

        <div class="auth-links">
            <p>Already have an account? <a href="/login">Sign In</a></p>
        </div>
    </div>
</div>
@endsection
