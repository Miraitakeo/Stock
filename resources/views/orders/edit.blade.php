@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-0">
                    <i class="fas fa-edit text-primary me-2"></i>Edit Order #{{ $order->id }}
                </h2>
                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-times me-1"></i> Cancel
                </a>
            </div>
        </div>

        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Please fix these errors:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form action="{{ route('orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Supplier *</label>
                        <select name="supplier_id" class="form-select" required>
                            @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ $order->supplier_id == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Order Status *</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="mb-3">
                        <i class="fas fa-boxes text-primary me-2"></i>Products & Quantities
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Current Stock</th>
                                    <th>Order Quantity</th>
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
                                    <td>
                                        <span
                                            class="badge bg-{{ $product->stock_quantity > 10 ? 'success' : 'warning' }}">
                                            {{ $product->stock_quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        <input type="number" name="quantities[{{ $product->id }}]"
                                            class="form-control form-control-sm" min="0"
                                            value="{{ $order->orderItems->firstWhere('product_id', $product->id)->quantity ?? 0 }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-end border-top pt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Update Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection