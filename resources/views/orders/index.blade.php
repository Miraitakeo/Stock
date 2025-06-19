@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">
                        <i class="fas fa-shopping-cart text-primary me-2"></i>Order Management
                    </h2>
                    <p class="text-muted mb-0">Track and manage purchase orders</p>
                </div>
                <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus-circle me-2"></i> New Order
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
                            <th class="py-3">Order ID</th>
                            <th class="py-3">Supplier</th>
                            <th class="py-3">Total Amount</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Order Date</th>
                            <th class="py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary">#{{ $order->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-3 bg-primary bg-opacity-10 rounded p-2">
                                        <i class="fas fa-truck text-primary"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $order->supplier->name }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td class="fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                @php
                                $statusColors = [
                                'pending' => 'warning',
                                'completed' => 'success',
                                'shipped' => 'info',
                                'cancelled' => 'danger'
                                ];
                                $color = $statusColors[strtolower($order->status)] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }} py-2 px-3">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <i class="far fa-calendar-alt me-2 text-muted"></i>
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info px-3"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-warning px-3"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Order">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Delete order #{{ $order->id }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-3"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Order">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="py-5">
                                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No orders found</h5>
                                    <p class="text-muted">Create your first purchase order</p>
                                    <a href="{{ route('orders.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus-circle me-2"></i> Create Order
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
@endsection

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