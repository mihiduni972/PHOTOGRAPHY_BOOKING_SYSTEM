<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
       
        $about_image = 'https://cdn.prod.website-files.com/63d28f848b9a1386c74c3794/63d4a39873eac00f5439ad8d_image16.jpeg';

        return view('about', compact('about_image'));
    }
}