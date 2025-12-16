<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('bookings.index', compact('categories'));
    }

    public function create($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->first();

        if (!$category) {
            return redirect()->route('booking.index')->with('error', 'Selected photography category not found.');
        }

        return view('bookings.create', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'nullable|date_format:H:i',
            'message' => 'nullable|string',
        ]);

        Booking::create([
            'category_id' => $request->category_id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'booking_date' => $request->booking_date,
            'booking_time' => $request->booking_time,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        $category = Category::find($request->category_id);
        $categoryName = $category ? $category->name : 'Photography Session';

        return redirect()->route('booking.index')->with('success', "Your booking for '{$categoryName}' has been placed successfully!");
    }
}