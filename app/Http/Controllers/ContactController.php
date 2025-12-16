<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Image;

class ContactController extends Controller
{
    public function show()
    {
        $contactBg = Image::where('type', 'contact_background')->first();
        $phoneIcon = Image::where('type', 'contact_icon_phone')->first();
        $emailIcon = Image::where('type', 'contact_icon_email')->first();
        $addressIcon = Image::where('type', 'contact_icon_address')->first();

        return view('contact', compact('contactBg', 'phoneIcon', 'emailIcon', 'addressIcon'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'message' => $request->message,
        ]);

        return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
    }
}