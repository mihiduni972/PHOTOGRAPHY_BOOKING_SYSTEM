@extends('layouts.app')

@section('content')
    <h1 class="mb-4 text-center">Book a {{ ucwords(str_replace('-', ' ', $category->name)) }} Session</h1>
    <p class="text-center">{{ $category->description }}</p>
    
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('booking.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="category_id" value="{{ $category->id }}">

                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Your Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Your Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">Your Phone (Optional)</label>
                        <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}">
                    </div>

                    <div class="mb-3">
                        <label for="booking_date" class="form-label">Preferred Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="booking_date" name="booking_date" value="{{ old('booking_date') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="booking_time" class="form-label">Preferred Time (Optional)</label>
                        <input type="time" class="form-control" id="booking_time" name="booking_time" value="{{ old('booking_time') }}">
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Additional Message (Optional)</label>
                        <textarea class="form-control" id="message" name="message" rows="3">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit Booking</button>
                    <a href="{{ route('booking.index') }}" class="btn btn-outline-secondary w-100 mt-2">Back to Categories</a>
                </form>
            </div>
        </div>
    </div>
@endsection