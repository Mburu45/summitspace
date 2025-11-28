@extends('layouts.public')

@section('content')

{{-- Hero Section --}}
<section class="hero">
    <div class="hero-bg" style="background-image: url('{{ asset('images/summit.png') }}')"></div>
    <div class="overlay"></div>
    <div class="hero-content fade-in">
        <h1>About SummitSpace</h1>
        <p>Gathering of Minds & Talents</p>
        <div class="cta-buttons">
            <a href="{{ route('events.index') }}" class="cta-btn primary">View Events</a>
            <a href="{{ route('contact') }}" class="cta-btn secondary">Contact Us</a>
        </div>
    </div>
</section>

{{-- About Section --}}
<section class="about">
    <div class="about-content fade-in">
        <h2>About SummitSpace</h2>
        <p>
            SummitSpace is your ultimate platform for gathering minds and talents.
            From tournaments to concerts, we bring communities together with seamless
            organization, ticketing, and engagement. Where ideas and events rise.
        </p>
        <a href="{{ route('contact') }}" class="learn-btn">Get In Touch</a>
    </div>
</section>

{{-- Mission Vision Values --}}
<section class="event-categories">
    <h2>Our Core</h2>
    <div class="event-grid">
        <div class="event-card fade-in">
            <div style="text-align: center; font-size: 3rem; margin-bottom: 1rem;">🎯</div>
            <h3>Mission</h3>
            <p>To connect people through amazing events and create unforgettable experiences.</p>
        </div>
        <div class="event-card fade-in">
            <div style="text-align: center; font-size: 3rem; margin-bottom: 1rem;">🌟</div>
            <h3>Vision</h3>
            <p>Be the leading platform for event discovery and community building worldwide.</p>
        </div>
        <div class="event-card fade-in">
            <div style="text-align: center; font-size: 3rem; margin-bottom: 1rem;">💡</div>
            <h3>Values</h3>
            <p>Innovation, community, accessibility, and excellence in everything we do.</p>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta">
    <h2>Ready to Join Our Community?</h2>
    <a href="{{ route('register') }}" class="cta-btn primary">Join Now</a>
</section>

@endsection