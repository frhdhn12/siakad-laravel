@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="text-center mb-4">
        <i class="bi bi-mortarboard-fill display-5 text-primary"></i>
        <h1 class="h3 fw-bold mb-1">{{ config('app.name') }}</h1>
        <p class="text-body-secondary mb-0">Politeknik Negeri Pontianak</p>
    </div>

    @include('layouts.partials.flash')

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Masuk ke akun Anda</h2>

            <form method="POST" action="{{ route('login.attempt') }}" novalidate>
                @csrf

                <div class="mb-3">
                    <x-form-input label="Email" name="email" type="email" 
                                  autocomplete="username" required autofocus />
                </div>

                <!-- Input Password dengan Tombol Show/Hide -->
                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" autocomplete="current-password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const toggleIcon = document.querySelector('#toggleIcon');

            if (togglePassword && password) {
                togglePassword.addEventListener('click', function () {
                    // Ubah tipe input dari password ke text atau sebaliknya
                    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                    password.setAttribute('type', type);
                    
                    // Ubah ikon mata Bootstrap Icons
                    toggleIcon.classList.toggle('bi-eye');
                    toggleIcon.classList.toggle('bi-eye-slash');
                });
            }
        });
    </script>
    @endpush
@endsection