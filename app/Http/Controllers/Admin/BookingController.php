<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Category;
use App\Models\BookingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['category'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['category', 'images']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $categories = Category::all();
        return view('admin.bookings.edit', compact('booking', 'categories'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string|max:255',
            'message' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);
        $booking->update($request->all());

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->images->count() > 0) {
            foreach ($booking->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }
            Storage::disk('public')->deleteDirectory('booking_images/' . $booking->id);
        }

        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }

    public function uploadImages(Request $request, Booking $booking)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'images.required' => 'Please select images.',
            'images.*.image' => 'The file must be an image.',
            'images.*.mimes' => 'Only JPEG, PNG, JPG, GIF image types are allowed.',
            'images.*.max' => 'The maximum size for a single image should be 5MB.',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('booking_images/' . $booking->id, 'public');
                BookingImage::create([
                    'booking_id' => $booking->id,
                    'image_path' => $path,
                ]);
            }
            return back()->with('success', 'Images uploaded successfully.');
        }

        return back()->with('error', 'Failed to upload images.');
    }

    public function destroyImage(BookingImage $image)
    {
        if (!$image) {
            return back()->with('error', 'Image not found.');
        }

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}