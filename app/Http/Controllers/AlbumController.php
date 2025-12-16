<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 

class AlbumController extends Controller
{
    public function index()
    {
        $categories = Category::all(); 
        return view('album', compact('categories')); 
    }

    public function show($categorySlug) 
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $albums = $category->albums; 
        return view('album_details', compact('category', 'albums'));
    }
}