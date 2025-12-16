<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminBookingController extends Controller
{
    public function showUploadForm()
    {
        $categories = Category::all();
        return view('admin.bookings.upload_form', compact('categories'));
    }

    public function uploadImages(Request $request, Booking $booking)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('booking_images/' . Str::slug($booking->category->name), 'public');

                    BookingImage::create([
                        'booking_id' => $booking->id,
                        'category_id' => $booking->category_id,
                        'file_path' => $path,
                        'file_name' => $image->getClientOriginalName(),
                    ]);
                }
            }
            DB::commit();
            return back()->with('success', 'Images uploaded successfully for booking!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to upload images: ' . $e->getMessage());
        }
    }

    public function processUpload(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $category = Category::findOrFail($request->category_id);

        DB::beginTransaction();
        try {
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('booking_images/' . Str::slug($category->name), 'public');

                    BookingImage::create([
                        'category_id' => $category->id,
                        'booking_id' => null,
                        'file_path' => $path,
                        'file_name' => $image->getClientOriginalName(),
                    ]);
                }
            }
            DB::commit();
            return back()->with('success', 'Images uploaded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to upload images: ' . $e->getMessage());
        }
    }

    public function destroyImage(BookingImage $image)
    {
        DB::beginTransaction();
        try {
            Storage::disk('public')->delete($image->file_path);

            $image->delete();

            DB::commit();
            return back()->with('success', 'Image deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete image: ' . $e->getMessage());
        }
    }
}