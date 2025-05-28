@extends('layouts.app')

@section('title', 'Connexion')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="shadow-lg card" style="width: 800px; border-radius: 20px; overflow: hidden;">
        <div class="row g-0">
            <!-- Formulaire -->
            <div class="p-5 col-md-6">
                <h2 class="mb-4 text-center" style="color: #333;">Connexion</h2>

                <form id="loginForm" action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label">Adresse e-mail :</label>
                        <input type="email" name="email" id="email" class="form-control input-field"
                            placeholder="Entrez votre email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Mot de passe :</label>
                        <input type="password" name="password" id="password" class="form-control input-field"
                            placeholder="Entrez votre mot de passe" required>
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Se souvenir de moi</label>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100 submit-button" id="loginButton">
                            <span id="button-text">Se connecter</span>
                            <span id="button-spinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>

                <p class="mt-3 text-center">
                    Vous n'avez pas encore de compte ?
                    <a href="{{ route('register.form') }}" class="text-primary">Inscrivez-vous ici</a>.
                </p>
            </div>

            <!-- Image -->
            <div class="col-md-6 d-flex align-items-center justify-content-center image-col">
                <img src="{{ asset('images/logo-ORTM.png') }}" alt="Logo ORTM" class="img-fluid" style="max-height: 250px;">
            </div>
        </div>
    </div>
</div>

<!-- Toastify Script -->
<script>
    const error = @json(session('error'));
    const success = @json(session('success'));

    if (error) {
        Toastify({
            text: error,
            duration: 5000,
            backgroundColor: "linear-gradient(to right, #FF6B6B, #D50000)",
            close: true,
            gravity: "top",
            position: "center",
            stopOnFocus: true,
            className: "toast-error"
        }).showToast();
    }

    if (success) {
        Toastify({
            text: success,
            duration: 5000,
            backgroundColor: "linear-gradient(to right, #28a745, #218838)",
            close: true,
            gravity: "top",
            position: "center",
            stopOnFocus: true,
            className: "toast-success"
        }).showToast();
    }

    // Affichage du spinner au clic
    document.getElementById('loginForm').addEventListener('submit', function () {
        const button = document.getElementById('loginButton');
        document.getElementById('button-text').textContent = 'Connexion en cours...';
        document.getElementById('button-spinner').classList.remove('d-none');
        button.disabled = true;
    });
</script>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #fff;
    }

    .card {
        background-color: #fff;
        border-radius: 25px;
        border: none;
        overflow: hidden;
    }

    .input-field {
        background-color: white;
        border-radius: 30px;
        padding-left: 20px;
        border: 1px solid #ddd;
        height: 45px;
        transition: border 0.3s ease;
    }

    .input-field:focus {
        border-color: #0056b3;
        box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
    }

    .submit-button {
        border-radius: 30px;
        padding: 12px 0;
        font-weight: bold;
        background-color: #0056b3;
        border: none;
        transition: background-color 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .submit-button:hover {
        background-color: #004085;
    }

    .form-control {
        font-size: 16px;
    }

    .form-label {
        color: #333;
    }

    .toast-error {
        font-weight: bold;
        font-size: 16px;
    }

    .toast-success {
        font-weight: bold;
        font-size: 16px;
    }

    .image-col {
        background-color: #fff;
        border-left: 1px solid #ddd;
    }

    .card .col-md-6:first-child {
        border-top-left-radius: 25px;
        border-bottom-left-radius: 25px;
    }

    .card .col-md-6:last-child {
        border-top-right-radius: 25px;
        border-bottom-right-radius: 25px;
    }
</style>

@endsection
