@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="text-center mb-4">Choose Your Photography Session</h2>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse ($categories as $category)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    @php
                        $imageToDisplay = null;
                        if ($category->booking_image_path) {
                            $imageToDisplay = asset('storage/' . $category->booking_image_path);
                        } elseif ($category->image_path) {
                            $imageToDisplay = asset('storage/' . $category->image_path);
                        } else {
                            $imageToDisplay = asset('images/default_category.png');
                        }
                    @endphp
                    <img src="{{ $imageToDisplay }}" class="card-img-top" alt="{{ $category->name }}" style="height: 200px; object-fit: cover;">

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="card-text flex-grow-1">{{ $category->description }}</p>

                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary mt-auto">Login to Book {{ $category->name }}</a>
                        @else
                            <a href="{{ route('booking.create', ['categorySlug' => Str::slug($category->name)]) }}" class="btn btn-primary mt-auto">Book {{ $category->name }}</a>
                        @endguest
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>No photography sessions available at the moment. Please check back later!</p>
            </div>
        @endforelse
    </div>
</div>
@endsection