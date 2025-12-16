{{-- resources/views/admin/bookings/index.blade.php --}}

@extends('admin.layouts.app') {{-- Extends your admin master layout --}}

@section('admin_content')
    <h2 class="mb-4">All Bookings</h2>

    {{-- Success/Error messages display --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Bookings List</h6>
            {{-- Optional: Button to add a new booking, uncomment if needed --}}
            {{-- <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add New Booking
            </a> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{-- DataTables plugin ID, keep only if you are using DataTables --}}
                <table class="table table-hover table-striped mb-0" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Booking ID</th>
                            <th>Category</th> {{-- Changed from 'Event Type' to 'Category' --}}
                            <th>Customer Name</th> {{-- Changed from 'Client Name' to 'Customer Name' --}}
                            <th>Customer Email</th>
                            <th>Booking Date</th> {{-- Changed from 'Event Date' to 'Booking Date' --}}
                            <th>Time Slot</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $booking->id }}</td>
                                {{-- Displaying category name if the relationship exists --}}
                                <td>{{ $booking->category->name ?? 'N/A' }}</td>
                                <td>{{ $booking->customer_name }}</td>
                                <td>{{ $booking->customer_email }}</td>
                                {{-- Formatting date using Carbon --}}
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}</td>
                                {{-- Displaying booking time if the field exists --}}
                                <td>{{ $booking->booking_time ? \Carbon\Carbon::parse($booking->booking_time)->format('h:i A') : 'N/A' }}</td>
                                <td>
                                    {{-- Status Badges for visual representation --}}
                                    <span class="badge {{
                                        $booking->status == 'pending' ? 'bg-warning text-dark' :
                                        ($booking->status == 'confirmed' ? 'bg-success' :
                                        ($booking->status == 'completed' ? 'bg-primary' :
                                        ($booking->status == 'cancelled' ? 'bg-danger' : 'bg-secondary')))
                                    }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        {{-- View Booking Details button --}}
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-info btn-sm" title="View Details">
                                            <i class="fas fa-eye"></i> View
                                        </a>

                                        {{-- Edit Booking button (if an edit form exists) --}}
                                        <a href="{{ route('admin.bookings.edit', $booking->id) }}" class="btn btn-warning btn-sm" title="Edit Booking">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        {{-- Delete Booking form --}}
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this booking? This action cannot be undone.');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Booking">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">No bookings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

{{-- Optional: Push scripts to the layout's script section --}}
@push('scripts')
    {{-- If you are using DataTables, load the relevant scripts here --}}
    {{-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script> --}}
    {{-- <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script> --}}
@endpush

{{-- Optional: Push custom CSS to the layout's style section for table and badges --}}
@push('styles')
    {{-- If you are using DataTables CSS, load it here --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css"> --}}
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .badge {
            padding: 0.5em 0.75em;
            font-size: 0.85em;
            border-radius: 0.25rem;
            font-weight: 600;
        }
    </style>
@endpush