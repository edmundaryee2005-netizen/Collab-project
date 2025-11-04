<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; // <-- Import Validator

class ProductController extends Controller
{
    public function __construct()
    {
        // Require authentication for all product routes
        $this->middleware('auth');
    }

    // 🏠 Show all products (now public, with search and filter)
    public function index(Request $request)
    {
        $query = Product::with('user', 'category')->latest();
        $searchTerm = $request->input('search');
        $sellerId = $request->input('seller_id');
        $sellerName = null;

        // ==== START: NEW SELLER FILTER ====
        // Check if a 'seller_id' was passed in the URL
        if ($sellerId) {
            // If filtering by seller, this query takes priority
            $query->where('user_id', $sellerId);
            
            // Find the seller's name so we can display it
            $seller = User::find($sellerId);
            $sellerName = $seller ? $seller->name : null;
        } 
        // ==== END: NEW SELLER FILTER ====
        
        // Only run the text search if we are NOT filtering by seller
        elseif ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('category', function($catQuery) use ($searchTerm) {
                        $catQuery->where('name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        // Execute the final query
        $products = $query->get();

        // Pass all data to the view
        return view('products.index', [
            'products' => $products,
            'searchTerm' => $searchTerm,
            'sellerName' => $sellerName // <-- Pass the seller's name to the view
        ]);
    }

    // ➕ Show create form
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // 💾 Save new product
    public function store(Request $request)
    {
        // 1. Get all request data
        $data = $request->all();

        // 2. Clean the price field *before* validation
        if (isset($data['price'])) {
            $data['price'] = preg_replace('/[^0-9.]/', '', $data['price']);
        }
        
        // 3. Clean the market_price_range field (if you have it in your form)
        if (isset($data['market_price_range'])) {
            $data['market_price_range'] = preg_replace('/[^0-9-]/', '', $data['market_price_range']);
        }
        
        // 4. Now, validate the *cleaned* data
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0', // This will now work
            'category_id' => 'required|exists:categories,id',
            'negotiable' => 'nullable|boolean',
            'market_price_range' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048', // <-- Fixed 2CH to 2048
            'phone' => ['nullable', 'string', 'max:20', 'starts_with:233'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('products.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        // 5. Get only the validated data
        $validatedData = $validator->validated();

        // 6. Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 7. Create the product
        Product::create([
            'user_id' => Auth::id(),
            'category_id' => $validatedData['category_id'],
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? '',
            'price' => $validatedData['price'],
            'negotiable' => $request->has('negotiable'), // Use $request->has for checkboxes
            'market_price_range' => $validatedData['market_price_range'] ?? null,
            'image' => $imagePath,
            'phone' => $validatedData['phone'] ?? null,
        ]);

        return redirect()->route('products.index')->with('success', 'Product uploaded successfully!');
    }

    // 👁️ Show one product
    public function show($id)
    {
        $product = Product::with('user', 'category')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    // ✏️ Edit form
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->authorizeUser($product);

        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // 🔁 Update product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->authorizeUser($product);

        // 1. Get all request data
        $data = $request->all();

        // 2. Clean the price field *before* validation
        if (isset($data['price'])) {
            $data['price'] = preg_replace('/[^0-9.]/', '', $data['price']);
        }
        
        // 3. Clean the market_price_range field
        if (isset($data['market_price_range'])) {
            $data['market_price_range'] = preg_replace('/[^0-9-]/', '', $data['market_price_range']);
        }

        // 4. Now, validate the *cleaned* data
        $validated = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0', // This will now work
            'category_id' => 'required|exists:categories,id',
            'negotiable' => 'nullable|boolean',
            'market_price_range' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048', // <-- Fixed 2048
            'phone' => ['nullable', 'string', 'max:20', 'starts_with:233'],
        ])->validate(); // We can use validate() here for simplicity

        // 5. Handle image update
        $imagePath = $product->image; // Keep old image by default
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // Store new image
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 6. Update the product
        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
            'price' => $validated['price'],
            'negotiable' => $request->has('negotiable'),
            'market_price_range' => $validated['market_price_range'] ?? null,
            'image' => $imagePath, // Use the new or existing image path
            'phone' => $validated['phone'] ?? null,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    // 🗑️ Delete product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->authorizeUser($product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    // 🛡️ Ensure only the owner can edit/delete
    private function authorizeUser($product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}

