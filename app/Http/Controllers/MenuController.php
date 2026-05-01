<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index() {
        $menuItems = MenuItem::all();
        return view('admin.add_menu_item', compact('menuItems'));
    }

    public function order() {
        $menuItems = MenuItem::all();

        return view('customer.order', compact('menuItems'));
    }

    public function store(Request $request) {
        $validated = $request->validate(
            [
                'itemName' => ['required', 'string', 'max:255'],
                'ingredients' => ['required', 'string'],
                'price' => ['required', 'numeric', 'min:0'],
                'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp','max:2048'],
                'category' => ['required', 'string']
            ]
        );

        $imagePath = $request->file('image')->store('menu_items', 'public');

        MenuItem::create([
            'item_name' => $validated['itemName'],
            'ingredients' => $validated['ingredients'],
            'price' => $validated['price'],
            'item_image' => $imagePath,
            'category' => $request->category,
        ]);

        return redirect()->route('menu.index')->with('success', 'Item added successfully');
    }

    public function edit(MenuItem $menu)
    {
        return view('admin.edit_menu_item', compact('menu'));
    }

    public function update(Request $request, MenuItem $menu)
    {
        $validated = $request->validate([
            'itemName'  => ['required', 'string', 'max:255'],
            'ingredients' => ['required', 'string'],
            'price'  => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'category' => ['required', 'string'],
        ]);

        // Only replace the image if a new one was uploaded
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($menu->item_image);
            $validated['item_image'] = $request->file('image')->store('menu_items', 'public');
        } else {
            $validated['item_image'] = $menu->item_image;
        }

        $menu->update([
            'item_name' => $validated['itemName'],
            'ingredients' => $validated['ingredients'],
            'price' => $validated['price'],
            'item_image' => $validated['item_image'],
            'category' => $validated['category'],
        ]);

        return redirect()->route('menu.index')->with('success', 'Item updated successfully');
    }

    public function destroy(MenuItem $menu)
    {
        Storage::disk('public')->delete($menu->item_image);
        $menu->delete();

        return redirect()->route('menu.index')->with('success', 'Item deleted successfully');
    }
}
