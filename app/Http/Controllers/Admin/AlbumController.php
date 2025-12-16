<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Category;
use App\Models\AlbumPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function index()
    {
        $albums = Album::with('category')->latest()->get();
        return view('admin.albums.index', compact('albums'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.albums.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:albums,name',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'nullable|numeric|min:0',
        ]);

        $album = new Album();
        $album->name = $request->name;
        $album->slug = Str::slug($request->name);
        $album->description = $request->description;
        $album->category_id = $request->category_id;
        $album->price = $request->input('price', 0);

        if ($request->hasFile('cover_image')) {
            $storedPath = $request->file('cover_image')->store('images/albums', 'public');
            $album->cover_image = $storedPath;
        }
        $album->save();

        if ($request->hasFile('images')) {
            $uploadedCount = 0;
            foreach ($request->file('images') as $imageFile) {
                if ($uploadedCount < 6) {
                    $imagePath = $imageFile->store('album_photos/' . $album->id, 'public');
                    AlbumPhoto::create([
                        'album_id' => $album->id,
                        'filename' => $imagePath,
                    ]);
                    $uploadedCount++;
                } else {
                    break;
                }
            }
            if ($uploadedCount >= 6) {
                return redirect()->route('admin.albums.show', $album->id)
                                 ->with('success', 'Album created successfully. Maximum 6 photos uploaded.')
                                 ->with('error', 'You can upload a maximum of 6 photos per album. Additional photos were not uploaded.');
            }
        }

        return redirect()->route('admin.albums.index')->with('success', 'Album created successfully.');
    }

    public function show(Album $album)
    {
        $album->load('category', 'photos');
        return view('admin.albums.show', compact('album'));
    }

    public function edit(Album $album)
    {
        $categories = Category::all();
        $album->load('photos');
        return view('admin.albums.edit', compact('album', 'categories'));
    }

    public function update(Request $request, Album $album)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:albums,name,' . $album->id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'nullable|numeric|min:0',
        ]);

        $album->name = $request->name;
        $album->slug = Str::slug($request->name);
        $album->description = $request->description;
        $album->category_id = $request->category_id;
        $album->price = $request->input('price', 0);

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) {
                Storage::disk('public')->delete($album->cover_image);
            }
            $storedPath = $request->file('cover_image')->store('images/albums', 'public');
            $album->cover_image = $storedPath;
        } elseif ($request->boolean('clear_cover_image')) {
            if ($album->cover_image) {
                Storage::disk('public')->delete($album->cover_image);
            }
            $album->cover_image = null;
        }

        $album->save();

        return redirect()->route('admin.albums.edit', $album->id)->with('success', 'Album updated successfully.');
    }

    public function destroy(Album $album)
    {
        if ($album->cover_image) {
            Storage::disk('public')->delete($album->cover_image);
        }

        $album->photos->each(function ($photo) {
            Storage::disk('public')->delete($photo->filename);
            $photo->delete();
        });
        Storage::disk('public')->deleteDirectory('album_photos/' . $album->id);

        $album->delete();
        return redirect()->route('admin.albums.index')->with('success', 'Album deleted successfully.');
    }

    public function uploadPhotos(Request $request, Album $album)
    {
        $currentPhotoCount = $album->photos()->count();

        $maxUploadable = 6 - $currentPhotoCount;

        if ($maxUploadable <= 0) {
            return back()->with('error', 'මෙම ඇල්බමයට තවත් පින්තූර උඩුගත කළ නොහැක. උපරිම පින්තූර 6කි.');
        }

        $request->validate([
            'photos' => 'required|array|min:1|max:' . $maxUploadable,
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'photos.required' => 'කරුණාකර පින්තූර තෝරන්න.',
            'photos.max' => 'ඔබට උඩුගත කළ හැක්කේ තවත් පින්තූර :max ක් පමණි.',
            'photos.*.image' => 'ගොනුව පින්තූරයක් විය යුතුය.',
            'photos.*.mimes' => 'JPEG, PNG, JPG, GIF වර්ගයේ පින්තූර පමණක් අවසරයි.',
            'photos.*.max' => 'එක් පින්තූරයක උපරිම ප්‍රමාණය 5MB විය යුතුය.',
        ]);

        if ($request->hasFile('photos')) {
            $uploadedThisSession = 0;
            foreach ($request->file('photos') as $file) {
                if ($currentPhotoCount + $uploadedThisSession < 6) {
                    $path = $file->store('album_photos/' . $album->id, 'public');
                    AlbumPhoto::create([
                        'album_id' => $album->id,
                        'filename' => $path,
                    ]);
                    $uploadedThisSession++;
                } else {
                    break;
                }
            }

            if ($uploadedThisSession > 0) {
                $message = 'පින්තූර සාර්ථකව උඩුගත කරන ලදී.';
                if ($uploadedThisSession < count($request->file('photos'))) {
                    $message .= ' (තෝරාගත් සියලුම පින්තූර උඩුගත කිරීමට නොහැකි විය. උපරිම පින්තූර 6කි.)';
                }
                return back()->with('success', $message);
            }
        }

        return back()->with('error', 'පින්තූර උඩුගත කිරීමට නොහැකි විය.');
    }

    public function destroyPhoto(AlbumPhoto $photo)
    {
        if (!$photo) {
            return back()->with('error', 'පින්තූරය සොයාගත නොහැක.');
        }

        if (Storage::disk('public')->exists($photo->filename)) {
            Storage::disk('public')->delete($photo->filename);
        }

        $photo->delete();

        return back()->with('success', 'පින්තූරය සාර්ථකව මකා දමන ලදී.');
    }
}