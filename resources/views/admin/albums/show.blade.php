{{-- resources/views/album/show.blade.php --}}

@extends('layouts.app') {{-- Your main frontend layout --}}

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Albums in: {{ $album->category->name ?? 'N/A' }}</h2>
    <h3 class="text-center text-muted mb-5">{{ $album->name }}</h3>

    {{-- Album Details (Optional, you can remove if not needed here) --}}
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2 text-center">
            @if($album->cover_image)
                <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->name }}" class="img-fluid rounded shadow-sm mb-3" style="max-height: 400px; object-fit: cover;">
            @endif
            <p class="lead">{{ $album->description ?? 'No description available for this album.' }}</p>
            @if($album->price > 0)
                <p><strong>Price:</strong> Rs. {{ number_format($album->price, 2) }}</p>
            @endif
            <a href="{{ route('album') }}" class="btn btn-outline-secondary mt-3">Back to All Albums</a>
        </div>
    </div>

    <hr class="my-5">

    <h3 class="text-center mb-4">Photos in {{ $album->name }}</h3>

    @if ($album->photos->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            මෙම ඇල්බමයට තවම පින්තූර එකතු කර නැත.
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($album->photos as $photo)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        {{-- Ensure 'filename' is used as per your AlbumPhoto model --}}
                        <img src="{{ asset('storage/' . $photo->filename) }}" class="card-img-top rounded" alt="Album Photo" style="height: 280px; object-fit: cover;">
                        @if($photo->caption)
                            <div class="card-body text-center">
                                <p class="card-text text-muted">{{ $photo->caption }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection