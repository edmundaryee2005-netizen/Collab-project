@extends('layouts.app')

{{-- Set the title to the product name --}}
@section('title', $product->name . ' | Shop zone')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Main Card for product details -->
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4 p-md-5">

                    <div class="row g-4">
                        
                        <!-- Column 1: Product Image -->
                        <div class="col-md-6">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded shadow-sm w-100" alt="{{ $product->name }}" style="max-height: 500px; object-fit: cover;">
                            @else
                                <img src="https://placehold.co/600x400?text=No+Image" class="img-fluid rounded shadow-sm w-100" alt="No Image">
                            @endif
                        </div>

                        <!-- Column 2: Product Details -->
                        <div class="col-md-6 d-flex flex-column">
                            
                            <!-- Product Name -->
                            <h1 class="h2 mb-2">{{ $product->name }}</h1>

                            <!-- Price -->
                            <p class="h3 fw-bold text-success mb-3">₵{{ number_format($product->price, 0) }}</p>

                            <!-- Negotiable/Market Price -->
                            @if($product->negotiable)
                                <span class="badge bg-info text-dark mb-3 fs-6">Price is negotiable</span>
                            @endif
                            
                            <!-- ==== START: MARKET RANGE FIX ==== -->
                            @if($product->market_price_range)
                                @php
                                    // Format the market price range
                                    $range = $product->market_price_range;
                                    $formattedRange = '';
                                    
                                    if (str_contains($range, '-')) {
                                        // It's a range like "20000-25000"
                                        // Split into two parts, max
                                        $parts = explode('-', $range, 2);
                                        // Format the 'from' part
                                        $from = is_numeric($parts[0]) ? number_format((float)$parts[0], 0) : $parts[0];
                                        // Format the 'to' part
                                        $to = (isset($parts[1]) && is_numeric($parts[1])) ? number_format((float)$parts[1], 0) : ($parts[1] ?? '');
                                        // Re-join them
                                        $formattedRange = $from . ' - ' . $to;
                                    } elseif (is_numeric($range)) {
                                        // It's a single number like "250000000"
                                        $formattedRange = number_format((float)$range, 0);
                                    } else {
                                        // Fallback for any other non-numeric string
                                        $formattedRange = $range;
                                    }
                                @endphp

                                <!-- Cedi icon for Market Range -->
                                <p class="small text-muted mt-n2 mb-3">
                                    Market Range: <strong class="text-dark">₵{{ $formattedRange }}</strong>
                                </p>
                            @endif
                            <!-- ==== END: MARKET RANGE FIX ==== -->

                            <!-- ==== START: WHATSAPP BUTTON LOGIC ==== -->
                            @if(Auth::check() && $product->phone && Auth::id() != $product->user_id)
                                <div class="d-grid gap-2 mb-4">
                                    <a href="https://wa.me/{{ $product->phone }}?text={{ urlencode('Hello, I am interested in your product: ' . $product->name) }}" 
                                       target="_blank" 
                                       class="btn btn-success btn-lg">
                                        <i class="bi bi-whatsapp me-2"></i>Contact Seller via WhatsApp
                                    </a>
                                </div>
                            @endif
                            <!-- ==== END: WHATSAPP BUTTON LOGIC ==== -->


                            <!-- Metadata List (Seller, Category, etc.) -->
                            <ul class="list-group list-group-flush mb-4">
                                <li class="list-group-item px-0">
                                    <strong>Seller:</strong> 
                                    <!-- 
                                      ==== CHANGE ====
                                      Changed the link to filter by 'seller_id' instead of 'search'
                                    -->
                                    <a href="{{ route('products.index', ['seller_id' => $product->user->id]) }}" class="text-success text-decoration-none fw-bold">
                                        {{ $product->user->name ?? 'N/A' }}
                                    </a>
                                </li>
                                <li class="list-group-item px-0">
                                    <strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}
                                </li>
                                <li class="list-group-item px-0">
                                    <strong>Posted:</strong> {{ $product->created_at->diffForHumans() }}
                                </li>
                            </ul>

                            <!-- Description -->
                            <h4 class="h5">Description</h4>
                            <p class="text-muted">{{ $product->description ?? 'No description provided.' }}</p>

                            <!-- Action Buttons (Edit/Delete) - Show only to owner -->
                            <div class="mt-auto">
                                @if(Auth::id() == $product->user_id)
                                    <div class="border-top pt-3 mt-3">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning me-2">Edit Product</a>
                                        
                                        <!-- Delete Button Form -->
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <!-- Fixed typo: typeG="submit" to type="submit" -->
                                            <button type="submit" class="btn btn-danger">Delete Product</button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div> <!-- / .row -->

                </div> <!-- / .card-body -->
            </div> <!-- / .card -->

            <!-- Back Button -->
            <div class="text-center mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">&laquo; Back to all products</a>
            </div>

        </div>
    </div>
</div>
@endsection

