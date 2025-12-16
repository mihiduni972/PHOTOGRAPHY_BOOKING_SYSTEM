{{-- resources/views/admin/albums/edit.blade.php --}}

@extends('admin.layouts.app')

@section('admin_content')
    <h2 class="mb-4">Edit Album: {{ $album->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5>Album editing errors:</h5>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Update Album Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.albums.update', $album->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Album Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $album->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $album->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $album->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $album->price) }}">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Cover Image</label>
                    @if ($album->cover_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->name }}" style="max-width: 200px; height: auto; border: 1px solid #ddd; padding: 5px; border-radius: 4px;">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="clear_cover_image" id="clear_cover_image" value="1">
                            <label class="form-check-label" for="clear_cover_image">
                                Remove current cover image
                            </label>
                        </div>
                    @else
                        <p>No cover image uploaded.</p>
                    @endif
                    <label for="cover_image" class="form-label mt-2">Upload New Cover Image (Optional)</label>
                    <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" accept="image/*">
                    @error('cover_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Album Details</button>
                <a href="{{ route('admin.albums.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

    {{-- Photo Upload Section --}}
    <div class="card shadow mb-4 mt-5">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Manage Album Photos</h6>
        </div>
        <div class="card-body">
            {{-- Photo Upload Form --}}
            @php
                $currentPhotoCount = $album->photos->count();
                $canUploadMore = $currentPhotoCount < 6;
                $remainingSlots = 6 - $currentPhotoCount;
            @endphp

            @if($canUploadMore)
                <form action="{{ route('admin.albums.upload-photos', $album->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <label for="photos" class="form-label">Add New Photos (You can upload {{ $remainingSlots }} more photos)</label>
                        <input type="file" class="form-control @error('photos.*') is-invalid @enderror @error('photos') is-invalid @enderror" id="photos" name="photos[]" multiple accept="image/*" {{ $canUploadMore ? '' : 'disabled' }}>
                        @error('photos.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        @error('photos')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">You can upload multiple photos at once. Max 5MB per photo.</small>
                    </div>
                    <button type="submit" class="btn btn-success" {{ $canUploadMore ? '' : 'disabled' }}>Upload Photos</button>
                </form>
            @else
                <div class="alert alert-info" role="alert">
                    The maximum number of photos (6) has already been uploaded for this album.
                </div>
            @endif

            <hr>

            {{-- Display Existing Photos --}}
            <h6 class="mt-4 mb-3">Current Photos ({{ $album->photos->count() }} / 6)</h6>
            <div class="row">
                @forelse($album->photos as $photo)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="photo-item border p-2 h-100 d-flex flex-column align-items-center justify-content-between text-center">
                            <img src="{{ asset('storage/' . $photo->filename) }}" alt="Album Photo" style="width: 100%; height: 150px; object-fit: cover; border-radius: 4px; margin-bottom: 10px;">
                            <span class="text-muted text-truncate w-100 mb-2">{{ basename($photo->filename) }}</span>
                            <form action="{{ route('admin.photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this photo?');" class="mt-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">No photos found for this album.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- You might need additional JS for dynamic photo uploads or previews if desired --}}
@endpush