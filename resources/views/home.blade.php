@extends('layouts.app')

@section('content')

{{-- Hero Section --}}
<section class="hero">
    <div class="hero-bg" style="background-image: url('{{ asset('images/summit.png') }}')"></div>
    <div class="overlay"></div>
    <div class="hero-content fade-in">
        <div class="logo-placeholder" style="margin-bottom:1rem;">
            <img src="{{ asset('images/summitlogo.png') }}" alt="summitlogo" style="width:150px;height:150px;border-radius:50%;">
            <h1 style="font-size:4rem;font-weight:bold;
                background: linear-gradient(45deg, var(--accent-color), var(--accent-purple));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;">
                SummitSpace
            </h1>
        </div>
        <h2 style="font-size:1.5rem;margin-bottom:0.5rem;">Gathering of Minds & Talents</h2>
        <p>Where Ideas and Events Rise.</p>
        <div class="cta-buttons">
            <a href="{{ route('events.index') }}" class="cta-btn primary">View Events</a>
            <a href="{{ route('register') }}" class="cta-btn secondary">Register Now</a>
        </div>
    </div>
</section>

{{-- Event Categories --}}
<section class="event-categories">
    <h2>Featured Events</h2>
    <div class="event-grid">
        @php
        $events = [
            ['id'=>1,'name'=>'FIFA Tournament','date'=>'November 1, 2025','icon'=>'🎮','image'=>'event1.png','description'=>'Compete in the ultimate football showdown!'],
            ['id'=>2,'name'=>'Jazz Night','date'=>'November 20, 2023','icon'=>'🎷','image'=>'jazz1.png','description'=>'Enjoy an evening of smooth jazz melodies.'],
            ['id'=>3,'name'=>'Hackathon','date'=>'December 5, 2023','icon'=>'💻','image'=>'hackathon1.png','description'=>'Code your way to innovation in 48 hours.'],
            ['id'=>4,'name'=>'Art Gallery Event','date'=>'January 10, 2024','icon'=>'🎨','image'=>'artgallery1.png','description'=>'Explore stunning artworks and meet talented artists.']
        ];
        @endphp

        @foreach($events as $event)
        <div class="event-card fade-in">
            <img src="{{ asset('images/'.$event['image']) }}" alt="{{ $event['name'] }}" class="event-img">
            <h3>{{ $event['name'] }}</h3>
            <p>{{ $event['description'] }}</p>
            <a href="{{ route('events.show', $event['id']) }}" class="learn-btn">Learn More</a>
        </div>
        @endforeach
    </div>
</section>

{{-- Countdown Timer --}}
<section class="countdown">
    <h2>Next Big Event: FIFA Tournament</h2>
    <div class="timer" id="countdown-timer">
        <div class="time-unit"><span class="number" id="days">0</span><span class="label">Days</span></div>
        <div class="time-unit"><span class="number" id="hours">0</span><span class="label">Hours</span></div>
        <div class="time-unit"><span class="number" id="minutes">0</span><span class="label">Minutes</span></div>
        <div class="time-unit"><span class="number" id="seconds">0</span><span class="label">Seconds</span></div>
    </div>
</section>

{{-- Timeline --}}
<section class="timeline">
    <h2>Upcoming Events Timeline</h2>
    <div class="timeline-container">
        @foreach($events as $index => $event)
        <div class="timeline-item {{ $index % 2 == 0 ? 'left' : 'right' }} fade-in">
            <div class="timeline-content">
                <span class="icon">{{ $event['icon'] }}</span>
                <h3>{{ $event['name'] }}</h3>
                <p>{{ $event['date'] }}</p>
            </div>
        </div>
        @endforeach
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
        <a href="{{ route('about') }}" class="learn-btn">Learn More</a>
    </div>
</section>

{{-- CTA --}}
<section class="cta">
    <h2>Ready to Experience the Best Events?</h2>
    <a href="{{ route('register') }}" class="cta-btn primary">Join Now</a>
</section>

@endsection

@section('scripts')
<script>
    // Countdown Timer JS
    const targetDate = new Date("2025-11-01T00:00:00").getTime();

    const updateCountdown = () => {
        const now = new Date().getTime();
        const difference = targetDate - now;
        if(difference > 0){
            const days = Math.floor(difference / (1000*60*60*24));
            const hours = Math.floor((difference % (1000*60*60*24))/(1000*60*60));
            const minutes = Math.floor((difference % (1000*60*60))/(1000*60));
            const seconds = Math.floor((difference % (1000*60))/1000);

            document.getElementById('days').innerText = days;
            document.getElementById('hours').innerText = hours;
            document.getElementById('minutes').innerText = minutes;
            document.getElementById('seconds').innerText = seconds;
        }
    }

    setInterval(updateCountdown, 1000);
</script>
@endsection
