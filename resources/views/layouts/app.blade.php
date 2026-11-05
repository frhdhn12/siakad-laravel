<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'SIAKAD') | {{ config('app.name') }}</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    <!-- DataTables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="{{ asset('css/siakad.css') }}" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    @stack('styles')
</head>
<body class="bg-body-tertiary">
    @include('layouts.partials.navbar')

    <div class="container-fluid">
        <div class="row">
            @include('layouts.partials.sidebar')
            <main class="col-lg-9 col-xl-10 px-3 px-md-4 py-4">
                @include('layouts.partials.flash')

                @yield('content')

                <footer class="text-center text-body-secondary small mt-5">
                    &copy; {{ date('Y') }} {{ config('app.name') }} 
                    - D3 Teknik Informatika
                </footer>
            </main>
        </div>
    </div>

    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables JS & Bootstrap 5 Integration -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        @if (session('success'))
        Toast.fire({
            icon: 'success',
            title: @json(session('success'))
        });
        @endif

        @if (session('error'))
        Toast.fire({
            icon: 'error',
            title: @json(session('error'))
        });
        @endif
    </script>
    @stack('scripts')
</body>
</html>