@extends('layouts.app') {{-- Navigation bar එක ඇති layout එක extend කරයි --}}

@section('content')

   
    <div class="video-hero-section">
        <video autoplay muted loop playsinline class="hero-video">
            <source src="{{ asset('videos/12504749_2560_1440_30fps.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="hero-overlay"></div> 
        <div class="hero-content animate-on-scroll fade-in-up">
            <h1>Capture Every Moment</h1>
            <p>At Mihi Photography, we specialize in capturing the magic of your events, from weddings to corporate gatherings, ensuring every moment is preserved forever.</p>
            <a href="{{ route('booking.index') }}" class="book-now-button">Book Now</a> 
        </div>
    </div>
    
    <div class="home-banner">
        
        <div class="scrolling-text-container">
            <div class="scrolling-text">MIHI PHOTOGRAPHY &nbsp;&nbsp;&nbsp; MIHI PHOTOGRAPHY &nbsp;&nbsp;&nbsp; MIHI PHOTOGRAPHY</div>
        </div>
       
        
        <div class="banner-images-container">
            <img src="{{ asset('images/65ff0956346c39d741249073_DSC_0820.jpg') }}" alt="Banner Image 1" class="banner-image-item animate-on-scroll fade-in-zoom" style="animation-delay: 0.1s;">
            <img src="{{ asset('images/65ff0956d9c8b3b5146a96a1_DSC_0913.jpg') }}" alt="Banner Image 2" class="banner-image-item animate-on-scroll fade-in-zoom" style="animation-delay: 0.3s;">
            <img src="{{ asset('images/65ff0956bf27147c20a802b2_DSC_0905.jpg') }}" alt="Banner Image 3" class="banner-image-item animate-on-scroll fade-in-zoom" style="animation-delay: 0.5s;">
        </div>
       
    </div>

    
    <div class="home-text-sections animate-on-scroll fade-in-up">
        <h1>EXPERIENCES THE ART OF PHOTOGRAPHY</h1>
        <p>{{ strtoupper('Our photography process is designed to be seamless and enjoyable. From the moment you book your session to the final delivery of your stunning images, we prioritize your needs and preferences. Let us turn your vision into reality with our expert guidance and artistic touch.') }}</p>
        <h1>WHAT WE DO</h1>
        <p>{{ strtoupper('At Mihi Photography, we believe every moment is unique. Our personalized photo sessions are designed to reflect your story, ensuring that each image resonates with your personality and style.') }}</p>
    </div>

   
    <div class="contact-section animate-on-scroll slide-in-left">
        <div class="contact-image">
           
            <img src="{{ asset('images/65fefa4d1f430c250136f7be_DSC02347.jpg') }}" alt="Contact Image">
        </div>
        <div class="contact-text">
            <h2>I want your wedding pictures to become a family heirloom.</h2>
            <p class="highlight-text">NOT JUST FOR YOU, BUT YOUR<br>CHILDREN AND YOUR CHILDREN'S<br>CHILDREN TOO.</p>
            <p>I've documented the marriage of over 50 couples in the last 03 years, and I'd love to hear about your wedding plans.</p>
            <p>Hit me up through this form or ping me via WhatsApp.</p>
            <p>I'll get back to you asap!</p>
            <p class="contact-detail">📞 +94 71 956 7512</p>
            <p class="contact-detail">📧 mihiphotography@gmail.com</p>
            <a href="https://wa.me/94719567512" target="_blank" class="whatsapp-button">
                Click to chat
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                root: null, 
                rootMargin: '0px',
                threshold: 0.1 
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target); 
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.animate-on-scroll').forEach(element => {
                observer.observe(element);
            });
        });
    </script>
@endsection