@extends('layouts.app')

@section('title', 'All Products | Shop zone')

@section('content')
<div class="container my-4">
        
    <h2 class="text-center mb-4">All Products</h2>
    
    <div class="d-flex justify-content-end mb-3">
         <a href="{{ route('products.create') }}" class="btn btn-success">+ Add Product</a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- START: Search/Filter Message -->
    {{-- This checks if we are filtering by a seller --}}
    @if(isset($sellerName))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            Showing all products by: <strong>{{ $sellerName }}</strong>
            {{-- This close button just links back to the main products page --}}
            <a href="{{ route('products.index') }}" class="btn-close" aria-label="Close"></a>
        </div>
    {{-- This checks if we are searching for a term --}}
    @elseif(isset($searchTerm) && $searchTerm != '')
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            Showing search results for: <strong>{{ $searchTerm }}</strong>
            <a href="{{ route('products.index') }}" class="btn-close" aria-label="Close"></a>
        </div>
    @endif
    <!-- END: Search/Filter Message -->

    @if($products->count() > 0)
        
        <div class="row g-4">

            @foreach($products as $product)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        
                        <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none;">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
                            @else
                                <img src="https://placehold.co/600x400?text=No+Image" class="card-img-top" alt="No Image" style="height: 180px; object-fit: cover;">
                            @endif
                        </a>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fs-6">
                                <a href="{{ route('products.show', $product->id) }}" class="text-dark" style="text-decoration: none;">
                                    {{ $product->name }}
                                </a>
                            </h5>
                            
                            <!-- ==== PRICE FIX HERE ==== -->
                            <p class="card-text fw-bold mb-2">₵{{ number_format($product->price, 0) }}</p>
                            <!-- ==== END PRICE FIX ==== -->
                            
                            <p class="card-text small text-muted mb-3">
                                {{ $product->category->name ?? 'N/A' }} <br>
                                By: {{ $product->user->name ?? 'N/A' }}
                            </p>
                            
                            <div class="mt-auto">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a>
                                
                                @if(Auth::id() == $product->user_id)
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm mx-1">Edit</a>
                                    
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div> <!-- End of .row -->

    @else
        <!-- START: No Products/Search Message -->
        <div class="text-center p-4 border rounded bg-white mt-4">
            {{-- Show a message if we filtered by seller and found nothing --}}
            @if(isset($sellerName))
                 <p class="mb-2 fs-5"><strong>{{ $sellerName }}</strong> hasn't uploaded any products yet.</p>
                 <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Back to All Products</a>
            {{-- Show a message if we searched and found nothing --}}
            @elseif(isset($searchTerm) && $searchTerm != '')
                <p class="mb-2 fs-5">No products found for "<strong>{{ $searchTerm }}</strong>".</p>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Clear Search</a>
            {{-- Show a message if the database is just empty --}}
            @else
                <p class="mb-2">No products have been uploaded yet.</p>
                <a href="{{ route('products.create') }}" class="btn btn-success">+ Be the First to Add a Product</a>
            @endif
        </div>
        <!-- END: No Products/Search Message -->
    @endif
</div>

@endsection