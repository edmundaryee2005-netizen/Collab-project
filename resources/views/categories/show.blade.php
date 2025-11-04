<!DOCTYPE html>
<html>
<head>
    <title>{{ $category->name }} - Jiji Clone</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2>{{ $category->name }}</h2>
        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-3">
                    <div class="card mb-3">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">₵{{ $product->price }}</p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No products found in this category.</p>
            @endforelse
        </div>

        <a href="{{ route('home') }}" class="btn btn-secondary">Back to Home</a>
    </div>
</body>
</html>
