<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'booking_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('category_covers', 'public');
            $category->image_path = $imagePath;
        }

        if ($request->hasFile('booking_image')) {
            $bookingImagePath = $request->file('booking_image')->store('booking_category_covers', 'public');
            $category->booking_image_path = $bookingImagePath;
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'booking_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
            }
            $imagePath = $request->file('image')->store('category_covers', 'public');
            $category->image_path = $imagePath;
        } elseif ($request->boolean('clear_image')) {
            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
                $category->image_path = null;
            }
        }

        if ($request->hasFile('booking_image')) {
            if ($category->booking_image_path) {
                Storage::disk('public')->delete($category->booking_image_path);
            }
            $bookingImagePath = $request->file('booking_image')->store('booking_category_covers', 'public');
            $category->booking_image_path = $bookingImagePath;
        } elseif ($request->boolean('clear_booking_image')) {
            if ($category->booking_image_path) {
                Storage::disk('public')->delete($category->booking_image_path);
                $category->booking_image_path = null;
            }
        }

        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }
        if ($category->booking_image_path) {
            Storage::disk('public')->delete($category->booking_image_path);
        }
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}