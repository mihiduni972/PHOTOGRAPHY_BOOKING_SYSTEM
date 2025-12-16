@extends('layouts.app')

@section('content')
<div class="album-page-container">
    <h1 class="album-heading animate-on-scroll fade-in-up">Our Photography Categories</h1>
    <p class="album-intro-paragraph animate-on-scroll fade-in-up" style="animation-delay: 0.2s;">
        Explore our curated collection of memories, categorized to easily find the perfect inspiration for your special moments. Each category features unique photography sessions, from grand weddings to intimate casual shoots.
    </p>

    <div class="albums-grid">
        @forelse ($categories as $category)
            <a href="{{ route('album.show', $category->slug) }}" class="album-card animate-on-scroll fade-in-zoom" style="animation-delay: {{ $loop->iteration * 0.15 }}s;">
                <div class="album-cover">
                    @if($category->image_path)
                       
                        <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }} Cover">
                    @else
                        <img src="{{ asset('images/default_category_cover.png') }}" alt="{{ $category->name }} Cover">
                    @endif
                    <div class="overlay"></div>
                </div>
                <div class="album-info">
                    <h3>{{ $category->name }}</h3>
                    <p>{{ $category->description }}</p>
                    <span>View Sessions &rarr;</span>
                </div>
            </a>
        @empty
            <div class="col-12 text-center">
                <p>No photography categories available at the moment. Please check back later!</p>
            </div>
        @endforelse
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
                } else {
                    
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-on-scroll').forEach(element => {
            observer.observe(element);
        });
    });
</script>
@endsection