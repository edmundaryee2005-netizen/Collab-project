@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="container">
    
    <!-- Page Header -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h2 class="h3 mb-0">My Dashboard</h2>
            <p class="text-muted">Welcome back, {{ $user->name }}!</p>
        </div>
        <div class="col-md-6 text-md-end">
            <!-- 'Add Product' button -->
            <a href="{{ route('products.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> Add New Product
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <hr class="mb-4">

    <!-- Section Title -->
    <!-- THE FIX: Changed class_ back to class -->
    <h3 class="mb-3">My Uploaded Products</h3>

    <!-- Check if there are any products -->
    @if($products->count() > 0)
        
        <!-- CARD GRID LAYOUT -->
        <div class="row g-4">
            <!-- Loop through each of the user's products -->
            @foreach($products as $product)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0 rounded-3">
                        
                        <!-- Clickable Product Image -->
                        <a href="{{ route('products.show', $product->id) }}">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
                            @else
                                <img src="https://placehold.co/600x400?text=No+Image" class="card-img-top" alt="No Image" style="height: 180px; object-fit: cover;">
                            @endif
                        </a>

                        <div class="card-body d-flex flex-column">
                            <!-- Clickable Product Title -->
                            <h5 class="card-title fs-6">
                                <a href="{{ route('products.show', $product->id) }}" class="text-dark" style="text-decoration: none;">
                                    {{ $product->name }}
                                </a>
                            </h5>
                            
                            <!-- Price -->
                            <p class="card-text fw-bold mb-2">₵{{ number_format($product->price, 2) }}</p>
                            
                            <!-- Category -->
                            <p class="card-text small text-muted mb-3">
                                {{ $product->category->name ?? 'N/A' }}
                            </p>
                            
                            <!-- Action buttons - mt-auto pushes them to the bottom -->
                            <div class="mt-auto">
                                <
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm mx-1">Edit</a>
                                
                                <!-- Delete Button Form -->
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> <!-- End of .row -->

    @else
        <!-- This message shows if they have no products -->
        <div class="text-center p-4 border rounded bg-white mt-4">
            <p class="mb-2">You haven't added any products yet.</p>
            <a href="{{ route('products.create') }}" class="btn btn-success">+ Add Your First Product</a>
        </div>
    @endif
</div>
@endsection

