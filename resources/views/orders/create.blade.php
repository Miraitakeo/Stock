@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-0">
                    <i class="fas fa-cart-plus text-primary me-2"></i>Create New Order
                </h2>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-times me-1"></i> Cancel
                </a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="supplier_id" class="form-label fw-bold">Supplier *</label>
                        <select name="supplier_id" id="supplier_id"
                            class="form-select @error('supplier_id') is-invalid @enderror" required>
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="mb-3">
                        <i class="fas fa-boxes text-primary me-2"></i>Order Items
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th class="text-end">Unit Price</th>
                                    <th class="text-end">Available Stock</th>
                                    <th class="text-end">Order Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2 bg-primary bg-opacity-10 rounded p-1">
                                                <i class="fas fa-box text-primary" style="font-size: 0.8rem"></i>
                                            </div>
                                            <span>{{ $product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-end">${{ number_format($product->price, 2) }}</td>
                                    <td class="text-end">
                                        <span
                                            class="badge bg-{{ $product->stock_quantity > 10 ? 'success' : 'warning' }}">
                                            {{ $product->stock_quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" name="quantities[{{ $product->id }}]"
                                            class="form-control form-control-sm @error('quantities.' . $product->id) is-invalid @enderror"
                                            min="0" value="{{ old('quantities.' . $product->id, 0) }}">
                                        @error('quantities.' . $product->id)
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-end border-top pt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-circle me-1"></i> Place Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection