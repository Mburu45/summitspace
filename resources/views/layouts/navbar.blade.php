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
        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li><a href="{{ route('events.index') }}">Events</a></li>
        <li><a href="{{ route('tickets.index') }}">Tickets</a></li>
        <li><a href="{{ route('profile.show') }}">Profile</a></li>

        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </li>
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
