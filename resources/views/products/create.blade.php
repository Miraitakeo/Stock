@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h4 mb-0">
                            <i class="fas fa-plus-circle text-primary me-2"></i>Add New Product
                        </h2>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to Products
                        </a>
                    </div>
                </div>

                <div class="card-body pt-1">
                    <form action="{{ route('products.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Product Name <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-tag text-muted"></i>
                                </span>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Enter product name" required value="{{ old('name') }}">
                                @error('name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="stock_quantity" class="form-label fw-bold">Stock Quantity <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fas fa-boxes text-muted"></i>
                                    </span>
                                    <input type="number" name="stock_quantity" id="stock_quantity"
                                        class="form-control @error('stock_quantity') is-invalid @enderror" min="0"
                                        required placeholder="0" value="{{ old('stock_quantity', 0) }}">
                                    @error('stock_quantity')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="price" class="form-label fw-bold">Unit Price <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">$</span>
                                    <input type="number" name="price" id="price"
                                        class="form-control @error('price') is-invalid @enderror" step="0.01" min="0"
                                        required placeholder="0.00" value="{{ old('price') }}">
                                    @error('price')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end border-top pt-4 mt-3">
                            <button type="reset" class="btn btn-outline-secondary me-3">
                                <i class="fas fa-undo me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save me-1"></i> Save Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
// Client-side form validation
document.addEventListener('DOMContentLoaded', function() {
    // Fetch all forms with validation needs
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})
</script>
@endsection
@endsection