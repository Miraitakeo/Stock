<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Controller</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #f8f9fc;
        --accent-color: #2e59d9;
    }

    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .banner {
        width: 100%;
        height: 300px;
        background-image: url("{{ asset('Image/Banner.avif') }}");
        background-size: cover;
        background-position: center;
        margin-bottom: 2rem;
        position: relative;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .banner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 100%);
        display: flex;
        align-items: center;
        padding: 2rem;
    }

    .banner-text {
        color: white;
        max-width: 600px;
    }

    .navbar {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        padding: 0.75rem 0;
        background: white !important;
    }

    .navbar-brand {
        font-weight: 800;
        font-size: 1.5rem;
        color: var(--primary-color) !important;
    }

    .nav-btn {
        border-radius: 0.35rem;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        transition: all 0.3s;
        border-width: 2px;
    }

    .nav-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .nav-btn.active {
        background-color: var(--primary-color);
        color: white !important;
    }

    .container-main {
        margin-top: 2rem;
        margin-bottom: 3rem;
    }

    @media (max-width: 768px) {
        .banner {
            height: 200px;
        }

        .banner-text h1 {
            font-size: 1.8rem;
        }

        .banner-text p {
            font-size: 1rem;
        }
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-boxes"></i> Stock Controller
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex flex-column flex-lg-row">
                    <a href="{{ route('dashboard') }}"
                        class="btn nav-btn me-2 mb-2 mb-lg-0 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="btn nav-btn me-2 mb-2 mb-lg-0 {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fas fa-box-open me-1"></i> Inventory
                    </a>
                    <a href="{{ route('suppliers.index') }}"
                        class="btn nav-btn me-2 mb-2 mb-lg-0 {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                        <i class="fas fa-truck me-1"></i> Suppliers
                    </a>
                    <a href="{{ route('orders.index') }}"
                        class="btn nav-btn me-2 mb-2 mb-lg-0 {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list me-1"></i> Orders
                    </a>

                    {{-- Logout --}}
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn nav-btn btn-outline-danger mb-2 mb-lg-0">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>


                </div>
            </div>
        </div>
    </nav>

    <div class="container container-main">
        <div class="banner">
            <div class="banner-overlay">
                <div class="banner-text">
                    <h1>Stock Management System</h1>
                    <p>Efficiently track and manage your inventory with our comprehensive stock control solution</p>
                </div>
            </div>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>