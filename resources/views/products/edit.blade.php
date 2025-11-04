@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card bg-white p-4 p-md-5 rounded shadow-sm">
                
                <h2 class="mb-4 text-center">Edit Product</h2>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">Please fix the errors:</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') {{-- Required for updates --}}

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category*</label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Select a Category --</option>
                            @foreach($categories as $category)
                                <!-- Populate with old input or existing product data -->
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name*</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Row for Price and Market Range -->
                    <div class="row">
                        <!-- Price -->
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Price*</label>
                            <div class="input-group">
                                <span class="input-group-text">₵</span>
                                <input type="number" name="price" id="price" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                            </div>
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Market Price Range -->
                        <div class="col-md-6 mb-3">
                            <label for="market_price_range" class="form-label">Market Price Range (Optional)</label>
                            <div class="input-group">
                                <span class="input-group-text">₵</span>
                                <input type="text" name="market_price_range" id="market_price_range" class="form-control @error('market_price_range') is-invalid @enderror" value="{{ old('market_price_range', $product->market_price_range) }}" placeholder="e.g. 90K - 95K">
                            </div>
                            @error('market_price_range')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Product Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Update Product Image</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$product->image) }}" alt="Current Image" class="img-thumbnail" width="150">
                                <p class="form-text">Current image. Uploading a new file will replace this.</p>
                            </div>
                        @endif
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ==== START: NEW PHONE FIELD ==== -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Contact Phone (WhatsApp)</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-whatsapp"></i>
                            </span>
                            <!-- Populate with old input or existing product phone -->
                            <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $product->phone) }}" placeholder="e.g. 233551234567">
                        </div>
                        <div class="form-text">
                            Enter the number you want buyers to contact for this product.
                        </div>
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- ==== END: NEW PHONE FIELD ==== -->


                    <!-- Negotiable Checkbox -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="negotiable" value="1" class="form-check-input" id="negotiable" {{ old('negotiable', $product->negotiable) ? 'checked' : '' }}>
                        <label class="form-check-label" for="negotiable">Is this price negotiable?</label>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-warning">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

