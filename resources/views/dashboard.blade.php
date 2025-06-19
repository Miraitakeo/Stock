@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-4 fw-bold text-primary">Dashboard</h1>
        <div class="text-muted">{{ now()->format('l, F j, Y') }}</div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-4">
            <div class="card border-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-muted">Total Stock Value</h5>
                            <h2 class="text-primary">${{ number_format($totalStockValue, 2) }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-boxes fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-success shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-muted">Total Orders</h5>
                            <h2 class="text-success">{{ $totalOrders }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-shopping-cart fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card border-info shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title text-muted">Total Suppliers</h5>
                            <h2 class="text-info">{{ $totalSuppliers }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-truck fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Income Section -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h3 class="h5 mb-0 text-primary">
                <i class="fas fa-calendar-alt me-2"></i>Monthly Income
            </h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3">Month</th>
                        <th class="py-3 text-end">Total Income</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyIncome as $data)
                    <tr>
                        <td class="py-3">{{ \Carbon\Carbon::parse($data->month)->format('F Y') }}</td>
                        <td class="py-3 text-end fw-bold">${{ number_format($data->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Income by Supplier -->
    <div class="card shadow mb-4">
        <div class="card-header bg-white py-3">
            <h3 class="h5 mb-0 text-primary">
                <i class="fas fa-chart-pie me-2"></i>Income by Supplier
            </h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">Supplier</th>
                            <th class="py-3 text-end">Total Income</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($incomeBySupplier as $data)
                        <tr>
                            <td class="py-3">{{ $data['supplier'] }}</td>
                            <td class="py-3 text-end fw-bold">${{ number_format($data['income'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="card shadow mt-4 border-warning">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0 text-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>Low Stock Alert
                </h3>
                <span class="badge bg-warning text-dark">{{ count($lowStockProducts) }} items</span>
            </div>
        </div>
        <div class="card-body p-0">
            @if(count($lowStockProducts) > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">Product</th>
                            <th class="py-3">Stock Quantity</th>
                            <th class="py-3">Price</th>
                            <th class="py-3 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockProducts as $product)
                        <tr>
                            <td class="py-3">
                                <div class="d-flex align-items-center">
                                    <div class="me-3 bg-danger bg-opacity-10 rounded-circle p-2">
                                        <i class="fas fa-box-open text-danger"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $product->name }}</strong>
                                        <div class="text-muted small">SKU: {{ $product->sku ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 align-middle">
                                <span class="badge bg-danger">{{ $product->stock_quantity }}</span>
                            </td>
                            <td class="py-3 align-middle">${{ number_format($product->price, 2) }}</td>
                            <td class="py-3 text-end align-middle">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-plus-circle me-1"></i> Restock
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-4 text-center text-muted">
                <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                <h5>All products are well stocked!</h5>
                <p class="mb-0">No products currently have low inventory levels.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection