@extends('admin.layouts.app') {{-- ඔබගේ admin layout එකට අනුකූලව මෙය වෙනස් කරන්න --}}

@section('admin_content')
    <h2 class="mb-4">Edit Category: {{ $category->name }}</h2>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- PUT method එක update සඳහා අත්‍යවශ්‍ය වේ --}}

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Album Cover Image Field --}}
        <div class="mb-3">
            <label for="image" class="form-label">Album Cover Image</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" onchange="previewImage(event, 'image_preview', 'image_preview_container', 'current_image_display', 'clear_image')">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($category->image_path)
                <div class="mt-2" id="current_image_display">
                    <p>Current Album Cover:</p>
                    <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}" width="100" class="img-thumbnail">
                    <div class="form-check mt-2">
                        <input type="checkbox" class="form-check-input" id="clear_image" name="clear_image" value="1">
                        <label class="form-check-label" for="clear_image">Remove current image</label>
                    </div>
                </div>
            @endif

            <div class="mt-2" id="image_preview_container" style="display: none;">
                <p>New Album Cover Preview:</p>
                <img id="image_preview" src="#" alt="Album Cover Preview" width="100" class="img-thumbnail">
            </div>
        </div>

        {{-- NEW: Booking Category Image Field --}}
        <div class="mb-3">
            <label for="booking_image" class="form-label">Booking Page Image</label>
            <input type="file" class="form-control @error('booking_image') is-invalid @enderror" id="booking_image" name="booking_image" onchange="previewImage(event, 'booking_image_preview', 'booking_image_preview_container', 'current_booking_image_display', 'clear_booking_image')">
            @error('booking_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($category->booking_image_path)
                <div class="mt-2" id="current_booking_image_display">
                    <p>Current Booking Page Image:</p>
                    <img src="{{ asset('storage/' . $category->booking_image_path) }}" alt="{{ $category->name }} Booking" width="100" class="img-thumbnail">
                    <div class="form-check mt-2">
                        <input type="checkbox" class="form-check-input" id="clear_booking_image" name="clear_booking_image" value="1">
                        <label class="form-check-label" for="clear_booking_image">Remove current booking image</label>
                    </div>
                </div>
            @endif

            <div class="mt-2" id="booking_image_preview_container" style="display: none;">
                <p>New Booking Page Image Preview:</p>
                <img id="booking_image_preview" src="#" alt="Booking Image Preview" width="100" class="img-thumbnail">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

    <script>
        // Common function for image preview and "remove" checkbox handling
        function previewImage(event, previewId, previewContainerId, currentDisplayId, clearCheckboxId) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById(previewId);
                output.src = reader.result;
                document.getElementById(previewContainerId).style.display = 'block';

                var currentDisplay = document.getElementById(currentDisplayId);
                if (currentDisplay) {
                    currentDisplay.style.display = 'none';
                }

                var clearCheckbox = document.getElementById(clearCheckboxId);
                if (clearCheckbox) {
                    clearCheckbox.checked = false;
                }
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Handle "Remove current image" checkbox for Album Cover
            var clearImageCheckbox = document.getElementById('clear_image');
            if (clearImageCheckbox) {
                clearImageCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        document.getElementById('image').value = '';
                        document.getElementById('image_preview_container').style.display = 'none';
                    } else {
                        var currentImageDisplay = document.getElementById('current_image_display');
                        if (currentImageDisplay && !document.getElementById('image').value) {
                            currentImageDisplay.style.display = 'block';
                        }
                    }
                });
            }

            // Handle "Remove current image" checkbox for Booking Page Image
            var clearBookingImageCheckbox = document.getElementById('clear_booking_image');
            if (clearBookingImageCheckbox) {
                clearBookingImageCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        document.getElementById('booking_image').value = '';
                        document.getElementById('booking_image_preview_container').style.display = 'none';
                    } else {
                        var currentBookingImageDisplay = document.getElementById('current_booking_image_display');
                        if (currentBookingImageDisplay && !document.getElementById('booking_image').value) {
                            currentBookingImageDisplay.style.display = 'block';
                        }
                    }
                });
            }
        });
    </script>
@endsection
