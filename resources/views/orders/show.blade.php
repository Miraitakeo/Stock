@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h4 mb-0">
                        <i class="fas fa-receipt text-primary me-2"></i>Order Details #{{ $order->id }}
                    </h2>
                </div>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to Orders
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="p-3 border rounded bg-light">
                        <h6 class="text-muted mb-2">Supplier</h6>
                        <p class="mb-0 fw-bold">
                            <i class="fas fa-truck text-muted me-2"></i>{{ $order->supplier->name }}
                        </p>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="p-3 border rounded bg-light">
                        <h6 class="text-muted mb-2">Status</h6>
                        @php
                        $statusClass = [
                        'pending' => 'warning',
                        'completed' => 'success',
                        'shipped' => 'info',
                        'cancelled' => 'danger'
                        ][strtolower($order->status)] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $statusClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="p-3 border rounded bg-light">
                        <h6 class="text-muted mb-2">Total Amount</h6>
                        <p class="mb-0 fw-bold">${{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="mb-3">
                    <i class="fas fa-box-open text-primary me-2"></i>Order Items
                </h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2 bg-primary bg-opacity-10 rounded p-1">
                                            <i class="fas fa-box text-primary" style="font-size: 0.8rem"></i>
                                        </div>
                                        <span>{{ $item->product->name }}</span>
                                    </div>
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">${{ number_format($item->price, 2) }}</td>
                                <td class="text-end fw-bold">${{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                            @endforeach
                            <tr class="table-light">
                                <td colspan="3" class="text-end fw-bold">Total:</td>
                                <td class="text-end fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if($order->status !== 'completed')
            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                <form action="{{ route('orders.restock', $order->id) }}" method="POST"
                    onsubmit="return confirm('This will return all items to inventory. Continue?')">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-undo me-1"></i> Restock Items
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection