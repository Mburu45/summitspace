@extends('layouts.public')

@section('content')

{{-- Hero Section --}}
<section class="hero">
    <div class="hero-bg" style="background-image: url('{{ asset('images/summit.png') }}')"></div>
    <div class="overlay"></div>
    <div class="hero-content fade-in">
        <h1>Contact Us</h1>
        <p>Get in Touch with SummitSpace</p>
        <div class="cta-buttons">
            <a href="{{ route('about') }}" class="cta-btn primary">Learn More</a>
            <a href="{{ route('events.index') }}" class="cta-btn secondary">View Events</a>
        </div>
    </div>
</section>

{{-- Contact Section --}}
<section class="about">
    <div class="about-content fade-in">
        <h2>Get in Touch</h2>
        <p>
            Have questions about our events or need assistance? We're here to help!
            Reach out to us through any of the channels below or send us a message.
        </p>
    </div>
</section>

{{-- Contact Details and Form --}}
<section class="event-categories">
    <div class="event-grid" style="grid-template-columns: 1fr 1fr; gap: 2rem;">
        <div class="event-card fade-in">
            <h3 style="color: var(--accent-color); margin-bottom: 1rem;">📧 Contact Information</h3>
            <p><strong>Email:</strong> info@summitspace.com</p>
            <p><strong>Phone:</strong> +254 700 000 000</p>
            <p><strong>Address:</strong> Nairobi, Kenya</p>
            <div style="margin-top: 2rem;">
                <h4 style="color: var(--accent-color); margin-bottom: 1rem;">Follow Us</h4>
                <div style="display: flex; gap: 1rem;">
                    <a href="#" class="learn-btn" style="text-decoration: none;">Facebook</a>
                    <a href="#" class="learn-btn" style="text-decoration: none;">Twitter</a>
                    <a href="#" class="learn-btn" style="text-decoration: none;">Instagram</a>
                </div>
            </div>
        </div>

        <div class="event-card fade-in">
            <h3 style="color: var(--accent-color); margin-bottom: 1rem;">📝 Send us a Message</h3>
            <form>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Your Name" required style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white;">
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Your Email" required style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white;">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Subject" required style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white;">
                </div>
                <div class="mb-3">
                    <textarea class="form-control" rows="4" placeholder="Your Message" required style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: white;"></textarea>
                </div>
                <button type="submit" class="cta-btn primary w-100">Send Message</button>
            </form>
        </div>
    </div>
</section>

@endsection