@extends('admin.layouts.app') {{-- ඔබේ ප්‍රධාන admin layout එක --}}

@section('admin_content')
    <h2 class="mb-4">Dashboard</h2>

    <div class="row">
        {{-- Total Categories Card --}}
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-primary h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-white">Total Categories</h5>
                            <h2 class="display-4 text-white">{{ $totalCategories }}</h2>
                        </div>
                        <i class="fas fa-th-list fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('admin.categories.index') }}" class="text-white text-decoration-none">View Categories <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        {{-- Total Bookings Card --}}
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-success h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-white">Total Bookings</h5>
                            <h2 class="display-4 text-white">{{ $totalBookings }}</h2>
                        </div>
                        <i class="fas fa-calendar-alt fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('admin.bookings.index') }}" class="text-white text-decoration-none">View Bookings <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        {{-- Pending Bookings Card --}}
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-warning h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-white">Pending Bookings</h5>
                            <h2 class="display-4 text-white">{{ $pendingBookings }}</h2>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('admin.bookings.index') }}?status=pending" class="text-white text-decoration-none">View Pending <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        {{-- Total Albums Card --}}
        <div class="col-md-3 mb-4">
            <div class="card text-white bg-info h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-white">Total Albums</h5>
                            <h2 class="display-4 text-white">{{ $totalAlbums }}</h2>
                        </div>
                        <i class="fas fa-images fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('admin.albums.index') }}" class="text-white text-decoration-none">View Albums <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        {{-- NEW: Total Customers Card --}}
        <div class="col-md-3 mb-4"> {{-- col-md-3, col-xl-3 දෙකම භාවිතා කළ හැක, ඔබේ අනෙකුත් card වලට ගැලපෙන ලෙස තෝරන්න --}}
            <div class="card text-white bg-secondary h-100 shadow-sm"> {{-- ඔබට වෙනස් background color එකක් (e.g., bg-dark, bg-success) හෝ border color එකක් (e.g., border-left-success) භාවිතා කළ හැක --}}
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-white">Total Customers</h5>
                            <h2 class="display-4 text-white">{{ $totalCustomers }}</h2>
                        </div>
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('admin.customers.index') }}" class="text-white text-decoration-none">View Customers <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    {{-- ඔබට මෙහි වෙනත් dashboard content එකතු කළ හැක --}}

@endsection