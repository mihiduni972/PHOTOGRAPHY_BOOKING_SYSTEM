@extends('layouts.app')

@section('content')
    <div class="album-details-page-container">
        <h1 class="album-details-heading animate-on-scroll fade-in-up">
            Albums in {{ $category->name ?? 'This Category' }}
        </h1>
        <p class="album-details-description animate-on-scroll fade-in-up" style="animation-delay: 0.2s;">
            {{ $category->description ?? 'Explore various albums within this photography category.' }}
        </p>

        @forelse ($albums as $album)
            <div class="album-section my-5 p-4 border rounded shadow-sm animate-on-scroll fade-in-zoom" style="animation-delay: {{ $loop->index * 0.15 + 0.4 }}s;">
                @if ($album->photos->count() > 0)
                    <div class="photos-grid row row-cols-1 row-cols-md-2 gx-3 gy-3">
                        @foreach ($album->photos->take(6) as $photo)
                            <div class="col p-0">
                                <div class="card h-100 border-0">
                                    <img src="{{ asset('storage/' . $photo->filename) }}" alt="{{ $photo->caption ?? $album->name }}" class="card-img-top rounded" style="height: 400px; width: 100%; object-fit: cover;">
                                    @if ($photo->caption)
                                        <div class="card-body p-2">
                                            <p class="card-text text-center text-muted small mb-0">{{ $photo->caption }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No individual photos available for this album yet.</p>
                @endif
            </div>
        @empty
            <div class="text-center py-5">
                <p class="lead text-muted">No albums found in this category.</p>
            </div>
        @endforelse

        <div class="text-center mt-5">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-lg rounded-pill px-4">Back to Categories</a>
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
                        // entry.target.classList.remove('is-visible');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.animate-on-scroll').forEach(element => {
                observer.observe(element);
            });
        });
    </script>
@endsection