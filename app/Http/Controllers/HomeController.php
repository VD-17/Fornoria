<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Gallery;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $starters = MenuItem::where('category', 'Starters')->get();
        $pizzas = MenuItem::where('category', 'Pizzas')->get();
        $drinks = MenuItem::where('category', 'Drinks')->get();
        $desserts = MenuItem::where('category', 'Desserts')->get();

        $galleryImages = Gallery::latest('uploadedAt')->take(5)->get();

        return view('customer.home', compact('starters', 'pizzas', 'drinks', 'desserts'));
    }

    public function about_index() {
        return view('customer.about');
    }
}
