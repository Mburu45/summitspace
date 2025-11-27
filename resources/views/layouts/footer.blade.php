<footer class="footer">
    <div class="footer-content">

        {{-- Quick Links --}}
        <div class="footer-section">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
                <li><a href="{{ route('events.index') }}">Events</a></li>
            </ul>
        </div>

        {{-- Socials --}}
        <div class="footer-section">
            <h3>Follow Us</h3>
            <div class="footer-socials">
                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="https://twitter.com" target="_blank" rel="noopener noreferrer">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer">
                    <i class="fa-brands fa-linkedin"></i>
                </a>
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer">
                    <i class="fa-brands fa-instagram"></i>
                </a>
            </div>
        </div>

        {{-- Newsletter --}}
        <div class="footer-section">
            <h3>Newsletter</h3>
            <form method="POST" action="#" class="newsletter-form">
                @csrf
                <input type="email" name="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>

    </div>

    <div class="footer-bottom">
        <p>
            © {{ date('Y') }} SummitSpace. All rights reserved. |
            <a href="{{ url('/privacy') }}">Privacy Policy</a> |
            <a href="{{ url('/terms') }}">Terms of Service</a>
        </p>
    </div>
</footer>
