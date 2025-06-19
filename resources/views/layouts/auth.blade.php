<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Controller - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    body {
        background-color: #f8f9fa;
        background-image: url("{{ asset('images/auth-bg.jpg') }}");
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        height: 100vh;
    }

    .card {
        border-radius: 0.5rem;
        border: none;
    }

    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
    </style>
</head>

<body class="d-flex align-items-center">
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>