@extends('admin.layouts.app') {{-- ඔබගේ admin layout එකට අනුකූලව මෙය වෙනස් කරන්න --}}

@section('admin_content')
    <h2 class="mb-4">Categories</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3">Create New Category</a>

    @if ($categories->isEmpty())
        <div class="alert alert-info">No categories found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ Str::limit($category->description, 70) }}</td>
                            <td>
                              @if ($category->image_path)
    {{-- මෙලෙස වෙනස් කරන්න --}}
    <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}" width="80" class="img-thumbnail">
@else
    No Image
@endif
                            </td>
                            <td>
                                <a href="{{ route('admin.categories.show', $category->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection