@extends('layouts.admin') {{-- ඔබේ admin master layout එක extend කරන්න --}}

@section('title', 'Upload Booking Images') {{-- පේජ් එකට title එකක් --}}

@section('content')
<script src="https://cdn.tailwindcss.com"></script> {{-- Tailwind CSS එක ඉක්මනින් පෙන්වීමට --}}

<div class="container mx-auto p-6 bg-gray-100 min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto mt-10">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Upload Booking Images</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.bookings.process-upload') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf {{-- CSRF token එක අමතක කරන්න එපා --}}

            {{-- Category Selection --}}
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Select Category:</label>
                <select name="category_id" id="category_id" class="shadow appearance-none border rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-blue-500 @error('category_id') border-red-500 @enderror" required>
                    <option value="">-- Select a Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Images Input --}}
            <div class="mb-4">
                <label for="images" class="block text-gray-700 text-sm font-bold mb-2">Upload Images (Max 2MB each):</label>
                <input type="file" name="images[]" id="images" multiple class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100
                    @error('images') border-red-500 @enderror @error('images.*') border-red-500 @enderror">
                <p class="text-gray-600 text-xs italic mt-2">You can select multiple images.</p>
                @error('images')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-200">
                    Upload Images
                </button>
                <a href="{{ route('admin.dashboard') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
