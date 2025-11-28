<nav class="navbar">
    <div class="navbar-logo">
        <a href="{{ url('/') }}">SummitSpace</a>
    </div>

    <div class="hamburger" id="hamburger">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <ul class="navbar-links" id="navbarLinks">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('events.index') }}">Events</a></li>
        @auth
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            @if(Auth::user()->role === 'admin')
                <li><a href="{{ route('admin.events.index') }}">Manage Events</a></li>
                <li><a href="{{ route('reports.index') }}">Reports</a></li>
            @elseif(Auth::user()->role === 'employee')
                <li><a href="{{ route('admin.events.index') }}">My Events</a></li>
                <li><a href="{{ route('reports.index') }}">Reports</a></li>
            @endif
            @if(Auth::user()->role === 'user')
                <li><a href="{{ route('bookings.index') }}">My Bookings</a></li>
            @endif
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </li>
        @else
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
        @endauth
    </ul>
</nav>

<script>
    const hamburger = document.getElementById('hamburger');
    const navbarLinks = document.getElementById('navbarLinks');

    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('open');
        navbarLinks.classList.toggle('open');
    });
</script>
