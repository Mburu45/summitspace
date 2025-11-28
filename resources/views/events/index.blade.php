@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5 fade-in">
        <h1 class="text-primary mb-2" style="color: var(--accent-color) !important;">Discover Amazing Events</h1>
        <p class="text-muted">Find and attend the best events in your area</p>
    </div>

    {{-- Search & Filter --}}
    <div class="d-flex justify-content-center gap-2 flex-wrap mb-4">
        <input type="text" id="searchInput" value="{{ $searchTerm }}" placeholder="Search events..." class="form-control" style="max-width: 250px;">
        <select id="categorySelect" class="form-control">
            <option value="all">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category }}" {{ $filterCategory === $category ? 'selected' : '' }}>{{ $category }}</option>
            @endforeach
        </select>
        <button type="button" id="filterBtn" class="btn btn-primary">Filter</button>
        <button type="button" id="clearBtn" class="btn btn-secondary">Clear</button>
    </div>

    {{-- Events Grid --}}
    @if(count($filteredEvents) === 0)
        <div class="text-center py-5">
            <h3>No events found matching your criteria</h3>
            <p>Try adjusting your search or filter settings</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($filteredEvents as $event)
            <div class="event-card fade-in" style="max-width: 350px; margin: 0 auto;">
                <div style="text-align: center; font-size: 3rem; padding: 1rem; background: linear-gradient(135deg, var(--accent-purple), var(--accent-color)); border-radius: 15px 15px 0 0;">
                    @if($event['category'] === 'Technology') 💻
                    @elseif($event['category'] === 'Music') 🎵
                    @elseif($event['category'] === 'Arts') 🎨
                    @else 📅
                    @endif
                </div>
                <div style="padding: 2rem;">
                    <h3 style="color: var(--accent-color); margin-bottom: 0.5rem;">{{ $event['title'] }}</h3>
                    <p style="color: var(--text-muted); margin-bottom: 1rem; font-size: 0.9rem;">{{ $event['description'] }}</p>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span style="font-weight: bold; color: var(--accent-orange);">{{ $event['price'] }}</span>
                        <span style="color: var(--text-muted); font-size: 0.8rem;">⭐ {{ $event['rating'] }} ({{ $event['attendees'] }} attending)</span>
                    </div>
                    <p style="margin-bottom: 0.5rem; font-size: 0.9rem; color: var(--text-muted);">📅 {{ \Carbon\Carbon::parse($event['date'])->format('D, M j, Y') }}</p>
                    <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;">📍 {{ $event['location'] }}</p>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <button type="button" class="learn-btn" onclick="showEventModal({{ $event['id'] }})" style="flex: 1; text-align: center;">Quick View</button>
                        @auth
                            @if($event['id'] <= 4) <!-- Only for hardcoded events -->
                                <a href="{{ route('bookings.create', $event['id']) }}" class="cta-btn primary" style="flex: 1; text-align: center; text-decoration: none;">Book Now</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="cta-btn primary" style="flex: 1; text-align: center; text-decoration: none;">Login to Book</a>
                        @endauth
                        <a href="{{ route('events.show', $event['id']) }}" class="cta-btn secondary" style="flex: 1; text-align: center; text-decoration: none;">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    {{-- CTA --}}
    <div class="cta fade-in">
        <h2>Can't Find What You're Looking For?</h2>
        <p>Check back later for more exciting events or contact us to suggest new ones!</p>
        <a href="{{ route('register') }}" class="cta-btn primary">Get Event Updates</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const categorySelect = document.getElementById('categorySelect');
    const filterBtn = document.getElementById('filterBtn');
    const clearBtn = document.getElementById('clearBtn');
    const eventsContainer = document.querySelector('.row.g-4');

    function filterEvents() {
        const searchTerm = searchInput.value;
        const category = categorySelect.value;

        // Show loading state
        eventsContainer.innerHTML = '<div class="col-12 text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

        // Make AJAX request
        fetch(`{{ route('events.index') }}?search=${encodeURIComponent(searchTerm)}&category=${encodeURIComponent(category)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.events && data.events.length > 0) {
                let html = '';
                data.events.forEach(event => {
                    const icon = event.category === 'Technology' ? '💻' :
                                event.category === 'Music' ? '🎵' :
                                event.category === 'Arts' ? '🎨' : '📅';
                    html += `
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <div class="card-header text-white text-center" style="background: linear-gradient(135deg, #6f42c1, #6610f2); font-size: 3rem;">
                                    ${icon}
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-primary">${event.title}</h5>
                                    <p class="card-text text-muted" style="font-size: 0.9rem;">${event.description}</p>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-bold text-warning">${event.price}</span>
                                        <span class="text-muted" style="font-size: 0.8rem;">⭐ ${event.rating} (${event.attendees} attending)</span>
                                    </div>
                                    <p class="mb-1" style="font-size: 0.9rem;">📅 ${new Date(event.date).toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' })}</p>
                                    <p style="font-size: 0.9rem;">📍 ${event.location}</p>
                                    <a href="{{ route('events.show', '') }}/${event.id}" class="btn btn-primary mt-auto">View Details</a>
                                </div>
                            </div>
                        </div>
                    `;
                });
                eventsContainer.innerHTML = html;
            } else {
                eventsContainer.innerHTML = `
                    <div class="col-12">
                        <div class="text-center py-5">
                            <h3>No events found matching your criteria</h3>
                            <p>Try adjusting your search or filter settings</p>
                        </div>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            eventsContainer.innerHTML = '<div class="col-12 text-center text-danger">Error loading events. Please try again.</div>';
        });
    }

    filterBtn.addEventListener('click', filterEvents);
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        categorySelect.value = 'all';
        filterEvents();
    });

    // Auto-filter on input change (debounced)
    let timeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(filterEvents, 500);
    });

    categorySelect.addEventListener('change', filterEvents);

    // Event modal functionality
    window.showEventModal = function(eventId) {
        const events = @json($filteredEvents);
        const event = events.find(e => e.id === eventId);

        if (event) {
            const modalHtml = `
                <div class="modal fade" id="eventModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${event.title}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-3">
                                    <span style="font-size: 4rem;">
                                        ${event.category === 'Technology' ? '💻' :
                                          event.category === 'Music' ? '🎵' :
                                          event.category === 'Arts' ? '🎨' : '📅'}
                                    </span>
                                </div>
                                <p><strong>Description:</strong> ${event.description}</p>
                                <p><strong>Date:</strong> ${new Date(event.date).toLocaleDateString()}</p>
                                <p><strong>Location:</strong> ${event.location}</p>
                                <p><strong>Price:</strong> ${event.price}</p>
                                <p><strong>Rating:</strong> ⭐ ${event.rating} (${event.attendees} attending)</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="{{ route('events.show', '') }}/${event.id}" class="btn btn-primary">View Full Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Remove existing modal if any
            const existingModal = document.getElementById('eventModal');
            if (existingModal) {
                existingModal.remove();
            }

            // Add modal to body
            document.body.insertAdjacentHTML('beforeend', modalHtml);

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('eventModal'));
            modal.show();
        }
    };
});
</script>
@endsection
