@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white border-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">
                        <i class="fas fa-truck text-primary me-2"></i>Suppliers
                    </h2>
                    <p class="text-muted mb-0">Manage your supplier contacts</p>
                </div>
                <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus-circle me-2"></i> Add Supplier
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
                            <th class="py-3">Name</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Phone</th>
                            <th class="py-3">Address</th>
                            <th class="py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suppliers as $supplier)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-3 bg-primary bg-opacity-10 rounded p-2">
                                        <i class="fas fa-building text-primary"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $supplier->name }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($supplier->email)
                                <a href="mailto:{{ $supplier->email }}" class="text-decoration-none">
                                    <i class="fas fa-envelope me-2 text-muted"></i>{{ $supplier->email }}
                                </a>
                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($supplier->phone)
                                <a href="tel:{{ $supplier->phone }}" class="text-decoration-none">
                                    <i class="fas fa-phone me-2 text-muted"></i>{{ $supplier->phone }}
                                </a>
                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                @if($supplier->address)
                                <i class="fas fa-map-marker-alt me-2 text-muted"></i>
                                <span>{{ Str::limit($supplier->address, 30) }}</span>
                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('suppliers.edit', $supplier) }}"
                                        class="btn btn-sm btn-primary px-3" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete {{ $supplier->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-3"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="py-5">
                                    <i class="fas fa-truck fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No suppliers found</h5>
                                    <p class="text-muted">Get started by adding your first supplier</p>
                                    <a href="{{ route('suppliers.create') }}" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus-circle me-2"></i> Add Supplier
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