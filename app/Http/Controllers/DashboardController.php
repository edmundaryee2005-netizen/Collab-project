<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 1. Get the currently logged-in user
        $user = Auth::user();

        // 2. Fetch products *only* belonging to this user
        $products = Product::with('category')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        // 3. Return the new dashboard view with the user's products
        return view('dashboard', [
            'user' => $user,
            'products' => $products
        ]);
    }
}
