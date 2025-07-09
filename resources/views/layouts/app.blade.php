<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    {{-- Required meta tags --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi POS Apotek dengan Laravel 11">
    <meta name="author" content="Alfansyah Yuandianto">

    {{-- Title --}}
    <title>POS Apotek Mufida Farma</title>

    {{-- Favicon icon --}}
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- Tabler Icons CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    {{-- Flatpickr CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">

    {{-- Template CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{-- jQuery Core --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    {{-- Header --}}
    <header>
        {{-- Navbar --}}
        @include('layouts.navbar')
    </header>

    {{-- Main Content --}}
    <main class="flex-shrink-0">
        <div class="container">
            <div class="page-content">
                {{-- menampilkan konten sesuai halaman yang dipilih --}}
                @hasSection('content')
                    @yield('content')
                @else
                    {{ $slot ?? '' }}
                @endif
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="footer bg-white shadow mt-auto py-3">
        <div class="container">
            <div class="d-flex flex-column flex-md-row align-items-center align-items-md-left">
                {{-- copyright --}}
                <div class="copyright text-center mb-2 mb-md-0">
                    <!-- &copy; 2024 - <a href="https://pustakakoding.com/" target="_blank" class="fw-semibold">Pustaka Koding</a>. All rights reserved. -->
                </div>
                {{-- link --}}
                <div class="link ms-md-auto">
                    <!-- <a href="https://pustakakoding.com/" target="_blank">Terms & Conditions</a> -->
                </div>
            </div>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    {{-- Flatpickr JS --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <!-- Select2 JS -->
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- jQuery Mask Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js" integrity="sha256-Kg2zTcFO9LXOc7IwcBx1YeUBJmekycsnTsq2RuFHSZU=" crossorigin="anonymous"></script>
    {{-- Sweetalert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Bootstrap Notify --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-notify@3.1.3/bootstrap-notify.min.js"></script>

    {{-- Custom Scripts --}}
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/image-preview.js') }}"></script>

    <script>
        // menampilkan pesan dengan sweetalert
        @if (session('success'))
            Swal.fire({
                icon: "success",
                title: "Success!",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @elseif (session('error'))
            Swal.fire({
                icon: "error",
                title: "Failed!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>
</body>

</html>