<?php

namespace App\Http\Controllers;

use App\Models\Category; // 1. Added Category model
use App\Models\Product; // 2. Added Product model
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     */
    public function index()
    {
        // 3. Kept your categories query
        $categories = Category::all();

        // 4. Fetched products, eager-loaded relationships, and limited to 16
        $products = Product::with('user', 'category')
                            ->latest()
                            ->take(16) // This is the limit you requested
                            ->get();

        // 5. Pass both variables to the view
        return view('home', compact('categories', 'products'));
    }
}

