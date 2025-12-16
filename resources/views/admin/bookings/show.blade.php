{{-- resources/views/admin/bookings/show.blade.php --}}
@extends('admin.layouts.app') {{-- Extend your master admin layout --}}

@section('admin_content')
<div class="container-fluid">
    {{-- Page Heading --}}
    <h1 class="h3 mb-4 text-gray-800">Booking Details: {{ $booking->customer_name ?? $booking->client_name }} ({{ $booking->category->name ?? $booking->event_type ?? 'N/A' }})</h1>

    {{-- Success and Error Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Booking Details Card --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Booking Information</h6>
            <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit Booking Details
            </a>
        </div>
        <div class="card-body">
            <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
            <p><strong>Category:</strong> {{ $booking->category->name ?? 'N/A' }}</p>
            <p><strong>Customer Name:</strong> {{ $booking->customer_name ?? 'N/A' }}</p>
            <p><strong>Customer Email:</strong> {{ $booking->customer_email ?? 'N/A' }}</p>
            <p><strong>Customer Phone:</strong> {{ $booking->customer_phone ?? 'N/A' }}</p>
            <p><strong>Booking Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}</p>
            <p><strong>Booking Time:</strong> {{ $booking->booking_time ?? 'N/A' }}</p>
            <p><strong>Message:</strong> {{ $booking->message ?? 'N/A' }}</p>
            <p><strong>Status:</strong> <span class="badge {{ $booking->status == 'pending' ? 'bg-warning text-dark' : ($booking->status == 'confirmed' ? 'bg-success' : ($booking->status == 'cancelled' ? 'bg-danger' : 'bg-info')) }}">{{ ucfirst($booking->status) }}</span></p>
            <p><strong>Created At:</strong> {{ $booking->created_at->format('Y-m-d H:i:s') }}</p>
            <p><strong>Updated At:</strong> {{ $booking->updated_at->format('Y-m-d H:i:s') }}</p>
            <hr>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary mt-3">Back to Bookings List</a>
        </div>
    </div>

    {{-- Booking Images Upload and Management Card --}}
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manage Booking Images</h6>
        </div>
        <div class="card-body">
            {{-- Image Upload Form --}}
            <form action="{{ route('admin.bookings.upload-images', $booking->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf
                <div class="form-group mb-3">
                    <label for="images">Select Images (Max 5):</label>
                    {{-- Added error classes and messages for 'images' field --}}
                    <input type="file" class="form-control @error('images.*') is-invalid @enderror @error('images') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*">
                    @error('images.*')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @error('images')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">You can upload multiple images at once. Max 5MB per image.</small>
                </div>
                <button type="submit" class="btn btn-primary">Upload Images</button>
            </form>

            <h5 class="mt-5 mb-3">Current Images ({{ $booking->images->count() }})</h5>
            @if ($booking->images->count() > 0)
                <div class="row">
                    @foreach ($booking->images as $image)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="{{ Storage::url($image->image_path) }}" class="card-img-top" alt="Booking Image" style="height: 180px; object-fit: cover;">
                                <div class="card-body text-center">
                                    <form action="{{ route('admin.booking-images.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No images available for this booking yet.</p>
            @endif
        </div>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to Bookings List</a>
    </div>

</div>
@endsection

@push('scripts')
    {{-- You might need additional JS for dynamic image uploads or previews if desired --}}
@endpush