{{-- resources/views/admin/customers/index.blade.php --}}
@extends('admin.layouts.app') {{-- ඔබේ ප්‍රධාන admin layout එකට අනුව මෙය වෙනස් කරන්න --}}

@section('admin_content')
    <h1 class="h3 mb-4 text-gray-800">Customers</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Customers</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="customersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Registered Date</th>
                            {{-- ඔබට අවශ්‍ය අනෙකුත් columns --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                                {{-- ඔබට අවශ්‍ය අනෙකුත් columns --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No customers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
{{-- ඔබට DataTables වැනි දෙයක් භාවිතා කරන්නේ නම්, මෙහි scripts ඇතුලත් කරන්න --}}
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<script>
    $(document).ready(function() {
        $('#customersTable').DataTable();
    });
</script>
@endpush