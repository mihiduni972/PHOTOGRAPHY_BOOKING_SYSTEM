@extends('layouts.app') 

@section('content')

<div class="contact-hero">
    <div class="hero-content">
        <h1>Get in Touch with Mihi Photography</h1>
        <p>We'd love to hear from you! Whether you have a question about our services, pricing, or anything else, our team is ready to answer all your inquiries.</p>
    </div>
</div>

<div class="contact-section">

    <div class="contact-cards-container">
        {{-- Email Card --}}
        <div class="contact-card">
            
            <div class="card-content">
                <h3>Email Address</h3>
                <p>info@mihiphotography.com</p>
            </div>
        </div>

       
        <div class="contact-card">
            
            <div class="card-content">
                <h3>Phone Us</h3>
                <p>+94 71 956 7512</p>
            </div>
        </div>

       
        <div class="contact-card">
            
            <div class="card-content">
                <h3>Find Us</h3>
                <p>258/1, Kottawa, Sri Lanka</p>
            </div>
        </div>
    </div> 

 
    <div class="contact-form-container">
        <h2>Send Us a Message</h2>
        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number (Optional)</label>
                <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ old('phone_number') }}">
                @error('phone_number')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="message">Your Message</label>
                <textarea id="message" name="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
                @error('message')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="submit-button">Send Message</button>
        </form>
    </div>
</div>


<div class="map-section">
    <div class="map-container">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.85196561214!2d79.97059107474415!3d6.786523193214539!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae245f7c32729f5%3A0x6b2e1f4d9b62a6b0!2sKottawa%2C%20Sri%20Lanka!5e0!3m2!1sen!2slk!4v1718426000000!5m2!1sen!2slk"
            width="100%"
            height="450"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>

@endsection