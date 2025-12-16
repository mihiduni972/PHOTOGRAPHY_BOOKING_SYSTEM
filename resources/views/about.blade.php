@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('content')

    <section class="full-screen-container about-us-section animate-fade-in">
        <h1>About Us</h1>
        <div class="about-us-image-container">
            <div class="slider-controls">
                <button class="prev-slide">&#10094;</button>
            </div>
            <div class="slider-wrapper">
                <div class="slider-track">
                    <div class="slide">
                        <img src="{{ asset('images/63d4a39873eac00f5439ad8d_image16.jpeg') }}" alt="Banner Image 1">
                    </div>
                    <div class="slide">
                        <img src="{{ asset('images/63d8ed217a7bb51a0d0dbf78_image6.jpeg') }}" alt="Banner Image 2">
                    </div>
                    <div class="slide">
                        <img src="{{ asset('images/63d4a39873eac0f1ca39ad95_image3.jpeg') }}" alt="Banner Image 3">
                    </div>
                </div>
            </div>
            <div class="slider-controls">
                <button class="next-slide">&#10095;</button>
            </div>
        </div>
        <p class="about-us-paragraph">
            Welcome to Mihi Photography, where every click tells a story. We are a team of passionate photographers dedicated to capturing life's most precious moments with creativity and precision. Our journey began with a simple belief: that every memory deserves to be preserved beautifully.
        </p>
        <p class="about-us-paragraph">
            From breathtaking landscapes to intimate portraits, grand weddings to vibrant events, we approach every project with unique vision and meticulous attention to detail. We believe in building connections with our clients, understanding their dreams, and transforming them into timeless images. Our commitment to excellence, combined with state-of-the-art equipment and a heartfelt approach, ensures that your experience with us is as memorable as the photographs we create.
        </p>
    </section>

    <section class="full-screen-container team-section animate-fade-in">
        <h2>Meet Our Team</h2>
        <div class="team-members-grid">
            <div class="team-member-card">
                <img src="{{ asset('images/photo-1495580621852-5de0cc907d2f.jpeg') }}" alt="Lakmal Sinharage" class="member-photo">
                <h3 class="member-name">Mihiduni Vinethma</h3>
                <p class="member-title">Founder & Lead Photographer</p>
                <p class="member-description">Mihiduni's vision and passion for photography laid the foundation for Mihi Photography. Her expertise in capturing candid moments makes his a true artist.</p>
            </div>
            <div class="team-member-card">
                <img src="{{ asset('images/pexels-annushka-ahuja-8114144.jpg') }}" alt="Amanda Perera" class="member-photo">
                <h3 class="member-name">Amanda Perera</h3>
                <p class="member-title">Senior Photographer</p>
                <p class="member-description">With an eye for detail and a knack for storytelling, Amanda brings life to every frame. She specializes in portrait and event photography.</p>
            </div>
            <div class="team-member-card">
                <img src="{{ asset('images/sanoj-kumar-bio-4295.jpg') }}" alt="Nimal Bandara" class="member-photo">
                <h3 class="member-name">Nimal Bandara</h3>
                <p class="member-title">Creative Director</p>
                <p class="member-description">Nimal oversees the creative direction, ensuring that every project reflects the unique style and high standards of Mihi Photography.</p>
            </div>
        </div>
    </section>

    <section class="full-screen-container values-section animate-fade-in">
        <h2>Our Core Values</h2>
        <div class="values-grid">
            <div class="value-item">
                <i class="fas fa-heart value-icon"></i>
                <h3 class="value-title">Passion</h3>
                <p class="value-description">We pour our heart and soul into every photograph, driven by a genuine love for the art of capturing moments.</p>
            </div>
            <div class="value-item">
                <i class="fas fa-lightbulb value-icon"></i>
                <h3 class="value-title">Creativity</h3>
                <p class="value-description">Innovation and artistic flair are at the core of our work, ensuring unique and captivating imagery every time.</p>
            </div>
            <div class="value-item">
                <i class="fas fa-handshake value-icon"></i>
                <h3 class="value-title">Integrity</h3>
                <p class="value-description">We operate with honesty, transparency, and respect, building lasting relationships with our clients.</p>
            </div>
            <div class="value-item">
                <i class="fas fa-gem value-icon"></i>
                <h3 class="value-title">Excellence</h3>
                <p class="value-description">We are committed to delivering the highest quality in every aspect of our service, from consultation to final delivery.</p>
            </div>
        </div>
    </section>

    <section class="full-screen-container cta-section animate-fade-in">
        <h2>Ready to Capture Your Story?</h2>
        <p>Let us help you create beautiful, lasting memories. Contact us today for a personalized photography experience.</p>
        <a href="{{ route('contact.show') }}" class="cta-button">Get in Touch</a>
    </section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sliderTrack = document.querySelector('.slider-track');
        const slides = document.querySelectorAll('.slider-track .slide');
        const prevButton = document.querySelector('.prev-slide');
        const nextButton = document.querySelector('.next-slide');
        let currentIndex = 0;
        const slideWidth = slides[0].clientWidth;

        function updateSlider() {
            sliderTrack.style.transform = `translateX(${-currentIndex * slideWidth}px)`;
        }

        nextButton.addEventListener('click', function() {
            currentIndex = (currentIndex + 1) % slides.length;
            updateSlider();
        });

        prevButton.addEventListener('click', function() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            updateSlider();
        });

        window.addEventListener('resize', function() {
            const currentSlideWidth = slides[0].clientWidth;
            sliderTrack.style.transform = `translateX(${-currentIndex * currentSlideWidth}px)`;
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const animateElements = document.querySelectorAll('.animate-fade-in');

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        animateElements.forEach(element => {
            observer.observe(element);
        });
    });
</script>
@endpush