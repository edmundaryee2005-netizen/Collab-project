<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Shop Zone</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    
    <!-- Added Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Rubik', sans-serif;
            background-color: #f8f9fa; /* Light gray background */
        }
        .navbar-brand {
            font-weight: 700;
        }
        .card-img-top {
            aspect-ratio: 1 / 1; /* Makes images square */
            object-fit: cover; /* Prevents stretching */
        }
        /* Style for the "View" button to match your other pages */
        .btn-info {
            color: #fff;
        }
        /* New styles for category cards */
        .category-card {
            display: block;
            text-decoration: none;
            color: #212529;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: .5rem;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.2s ease-in-out;
            font-weight: 500;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
            color: #198754; /* Green on hover */
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">Shop Zone</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <!-- Updated products link to go to the main products page -->
                        <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                    </li>
                    
                    <!-- Login/Register buttons -->
                    @guest
                        <li class="nav-item w-100 w-lg-auto">
                            <a href="{{ route('login') }}" class="btn btn-light-green ms-lg-3 w-100 w-lg-auto mt-2 mt-lg-0">Login</a>
                        </li>
                        <li class="nav-item w-100 w-lg-auto">
                            <a href="{{ route('register') }}" class="btn btn-success ms-lg-2 w-100 w-lg-auto mt-2 mt-lg-0">Register</a>
                        </li>
                    @else
                        <!-- If user is logged in, show a dashboard dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                            Log Out
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Banner Section -->
    <header class="bg-success text-white text-center py-5">
        <div class="container py-4">
            <h1 class="display-4 fw-bold">Welcome to Shop Zone</h1>
            <p class="lead fs-5">Buy, Sell, and Connect with others easily. The Ultimate Online Shopping Experience. Your #No1 shopping site</p>
        </div>
    </header>

    <!-- ======== NEW CATEGORIES SECTION ======== -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="mb-4 text-center">Browse by Category</h2>
            
            @if($categories->count() > 0)
                <div class="row g-3">
                    @foreach($categories as $category)
                        <div class="col-6 col-md-4 col-lg-2">
                            <!-- This now links to the products page, searching for the category -->
                            <a href="{{ route('products.index', ['search' => $category->name]) }}" class="category-card">
                                {{ $category->name }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-muted">No categories set up yet.</p>
            @endif
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4 text-center">Featured Products</h2>
            
            <!-- Check if any products were passed -->
            @if($products->count() > 0)
                <div class="row g-4">
                    <!-- Loop through each product -->
                    @foreach($products as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card h-100 shadow-sm border-0 rounded-3">
                                
                                <!-- Clickable Product Image -->
                                <a href="{{ route('products.show', $product->id) }}">
                                    @if($product->image)
                                        <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                    @else
                                        <img src="https://placehold.co/600x400?text=No+Image" class="card-img-top" alt="No Image">
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
                                    
                                    <!-- Category and Seller -->
                                    <p class="card-text small text-muted mb-3">
                                        {{ $product->category->name ?? 'N/A' }} <br>
                                        By: {{ $product->user->name ?? 'N/A' }}
                                    </p>
                                    
                                    <!-- View Button (pushed to bottom) -->
                                    <div class="mt-auto">
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Show this if the database is empty -->
                <div class="text-center p-4 border rounded bg-white mt-4">
                    <p class="mb-2">No products have been uploaded yet.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Shop zone. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

