<!DOCTYPE html>
<html>
<head>
    <title>Jiji Clone - Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container py-4">
        <h1 class="mb-4 text-center">Jiji Clone</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('products.create') }}" class="btn btn-primary">+ Upload Product</a>
        </div>

        @foreach ($categories as $category)
            <h3 class="mt-5">{{ $category->name }}</h3>
            <div class="row">
                @forelse ($category->products as $product)
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
                    <p>No products available in this category yet.</p>
                @endforelse
            </div>
        @endforeach
    </div>
</body>
</html>
