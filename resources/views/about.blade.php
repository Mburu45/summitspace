@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="mb-4">About SummitSpace</h1>
            <p class="lead mb-4">
                SummitSpace is your ultimate platform for gathering minds and talents.
                From tournaments to concerts, we bring communities together with seamless
                organization, ticketing, and engagement.
            </p>

            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="feature-card">
                        <h3>🎯 Mission</h3>
                        <p>To connect people through amazing events and create unforgettable experiences.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <h3>🌟 Vision</h3>
                        <p>Be the leading platform for event discovery and community building worldwide.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <h3>💡 Values</h3>
                        <p>Innovation, community, accessibility, and excellence in everything we do.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.feature-card {
    padding: 2rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 2rem;
}
</style>
@endsection