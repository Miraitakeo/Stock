@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">
                        <i class="fas fa-boxes text-primary me-2"></i>Product Inventory
                    </h2>
                    <p class="text-muted mb-0">Manage your product catalog</p>
                </div>
                <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus-circle me-2"></i> Add Product
                </a>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 ps-4">Product Name</th>
                            <th class="py-3">Stock</th>
                            <th class="py-3">Unit Price</th>
                            <th class="py-3 pe-4 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="me-3 bg-primary bg-opacity-10 rounded p-2">
                                        <i class="fas fa-box text-primary"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $product->name }}</strong>
                                        <div class="text-muted small">SKU: {{ $product->sku ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($product->stock_quantity < 10) <span class="badge bg-danger py-2 px-3">
                                    {{ $product->stock_quantity }}</span>
                                    @elseif($product->stock_quantity < 25) <span
                                        class="badge bg-warning text-dark py-2 px-3">
                                        {{ $product->stock_quantity }}</span>
                                        @else
                                        <span class="badge bg-success py-2 px-3">{{ $product->stock_quantity }}</span>
                                        @endif
                            </td>
                            <td class="fw-bold">${{ number_format($product->price, 2) }}</td>
                            <td class="pe-4">
                                <div class="d-flex justify-content-end gap-3">
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary px-4 py-2"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <i class="fas fa-edit me-2"></i> Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete {{ $product->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger px-4 py-2" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Delete">
                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <div class="py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No products found</h5>
                                    <p class="text-muted">Get started by adding your first product</p>
                                    <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg mt-3">
                                        <i class="fas fa-plus-circle me-2"></i> Add Product
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection
@endsection