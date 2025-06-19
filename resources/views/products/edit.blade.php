@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>Edit Product</h1>
                </div>

                <div class="card-body">
                    <form action="{{ route('products.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                required value="{{ old('name', $product->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                            <input type="number" name="stock_quantity"
                                class="form-control @error('stock_quantity') is-invalid @enderror" required min="0"
                                value="{{ old('stock_quantity', $product->stock_quantity) }}">
                            @error('stock_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price (per unit) *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="price"
                                    class="form-control @error('price') is-invalid @enderror" step="0.01" min="0"
                                    required value="{{ old('price', $product->price) }}">
                            </div>
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection