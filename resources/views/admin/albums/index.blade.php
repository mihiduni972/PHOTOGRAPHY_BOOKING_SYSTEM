{{-- resources/views/admin/albums/index.blade.php --}}

@extends('admin.layouts.app')

@section('admin_content')
    <h2 class="mb-4">All Albums</h2>

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

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Albums List</h5>
            <a href="{{ route('admin.albums.create') }}" class="btn btn-primary btn-sm">Add New Album</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cover Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($albums as $album)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
    {{-- **මෙයයි වෙනස් කළ යුත්තේ: $album->image_path වෙනුවට $album->cover_image යොදන්න** --}}
    @if($album->cover_image)
        <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->name }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 4px;">
    @else
        <img src="{{ asset('images/default_album_cover.png') }}" alt="No Cover" style="width: 70px; height: 70px; object-fit: cover; border-radius: 4px;">
    @endif
</td>
                                <td>{{ $album->name }}</td> {{-- Album model එකේ 'name' attribute එක තිබිය යුතුය --}}
                                <td>{{ $album->category->name ?? 'N/A' }}</td> {{-- Album model එකේ 'category' relationship එක තිබිය යුතුය --}}
                                <td>{{ Str::limit($album->description, 100) }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        {{-- 'admin.albums.show' route එක කලින් 'admin.albums.details' ලෙස තිබුණි, දැන් එය Route::resource එකේ show method එකට යයි --}}
                                        <a href="{{ route('admin.albums.show', $album->id) }}" class="btn btn-info btn-sm" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.albums.edit', $album->id) }}" class="btn btn-warning btn-sm" title="Edit Album">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.albums.destroy', $album->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this album?');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Album">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No albums found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Optional: If you need Font Awesome icons and they are not globally included,
         or if you are using a specific version like 6.0.0-beta3, ensure it's loaded in app.blade.php
         The main app.blade.php already includes the latest Font Awesome. --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script> --}}
@endpush