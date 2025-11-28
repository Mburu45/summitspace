@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="text-center mb-5">Contact Us</h1>

            <div class="row">
                <div class="col-md-6">
                    <div class="contact-info">
                        <h3>Get in Touch</h3>
                        <p><strong>📧 Email:</strong> info@summitspace.com</p>
                        <p><strong>📞 Phone:</strong> +254 700 000 000</p>
                        <p><strong>📍 Address:</strong> Nairobi, Kenya</p>

                        <div class="social-links mt-4">
                            <a href="#" class="social-link">Facebook</a>
                            <a href="#" class="social-link">Twitter</a>
                            <a href="#" class="social-link">Instagram</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <form class="contact-form">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Subject" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.contact-info {
    padding: 2rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.social-links {
    display: flex;
    gap: 1rem;
}

.social-link {
    color: var(--accent-color);
    text-decoration: none;
    padding: 0.5rem 1rem;
    border: 1px solid var(--accent-color);
    border-radius: 5px;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: var(--accent-color);
    color: white;
}
</style>
@endsection