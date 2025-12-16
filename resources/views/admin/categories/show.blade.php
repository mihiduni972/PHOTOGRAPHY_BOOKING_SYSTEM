@extends('admin.layouts.app') {{-- ඔබගේ admin layout එකට අනුකූලව මෙය වෙනස් කරන්න --}}

@section('admin_content')
    <h2 class="mb-4">Category Details: {{ $category->name }}</h2>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $category->name }}</h5>
            <p class="card-text"><strong>Description:</strong> {{ $category->description }}</p>
            <p class="card-text"><strong>Slug:</strong> {{ $category->slug }}</p>

       @if ($category->image_path)
    <div class="mb-3">
        <strong>Category Image:</strong><br>
        {{-- මෙලෙස වෙනස් කරන්න --}}
        <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}" class="img-fluid" style="max-width: 300px;">
    </div>
@else
    <p><strong>Category Image:</strong> No Image</p>
@endif

            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">Edit Category</a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back to Categories</a>
        </div>
    </div>
@endsection