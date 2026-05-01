<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index() {
        $images = Gallery::all();

        return view('admin.add_gallery', compact('images'));
    }

    public function add(Request $request) {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $imagePath = $request->file('image')->store('gallery_images', 'public');

        Gallery::create([
            'imageUrl' => $imagePath,
            'uploadedAt' => now(),
        ]);

        return redirect()->route('gallery.index')->with('success', 'Image added successfully');
    }

    public function delete(Gallery $image) {
        Storage::disk('public')->delete($image->imageUrl);

        $image->delete();

        return redirect()->route('gallery.index')->with('success', 'Image deleted successfully');
    }
}
