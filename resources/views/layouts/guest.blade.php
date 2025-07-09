<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    {{-- Required meta tags --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi POS Apotek dengan Laravel">
    <meta name="author" content="Alfansyah Yuandianto">

    {{-- Title --}}
    <title>POS Apotek Mufida Farma - Login</title>

    {{-- Favicon icon --}}
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    {{-- Tabler Icons CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    {{-- Flatpickr CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Template CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- jQuery Core --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <!-- CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>

<body>
    <main class="w-100">
        <div class="container-fluid vh-100 d-flex p-0">
            <div class="row flex-grow-1 m-0 w-100">
                <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center" style="background-color: #4CAF50; color: white; padding: 3rem;">
                    <!-- <img src="{{ asset('images/logo-dashboard.png') }}" alt="Apotek Logo" class="mb-4" style="max-width: 150px;"> -->
                    <h1 class="fw-bold">APOTEK MUFIDA FARMA</h1>
                </div>
                <div class="col-lg-6 d-flex flex-column justify-content-center align-items-center p-5">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
