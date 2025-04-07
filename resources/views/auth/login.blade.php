@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="shadow-lg card" style="width: 800px; border-radius: 15px;">
        <div class="row g-0">
            <!-- Colonne gauche : Formulaire -->
            <div class="p-5 col-md-6">
                <h2 class="mb-4 text-center" style="color: #333;">Connexion</h2>
                <form action="{{ route('login.submit') }}" method="POST">
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
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Se souvenir de moi</label>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100 submit-button">Se connecter</button>
                    </div>
                </form>
                <p class="mt-3 text-center">
                    Vous n'avez pas encore de compte ?
                    <a href="{{ route('register.form') }}" class="text-primary">Inscrivez-vous ici</a>.
                </p>
            </div>

            <!-- Colonne droite : Image -->
            <div class="col-md-6 d-flex align-items-center justify-content-center bg-light"
                style="border-left: 1px solid #ddd;">
                <img src="{{ asset('images/logo-ORTM.png') }}" alt="Logo ORTM" class="img-fluid"
                    style="max-height: 250px;">
            </div>
        </div>
    </div>
</div>

<!-- Inclure Toastify JS et CSS -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<script>
    const val = session('error');
    if (session('error'))
        Toastify({
            text: val,
            duration: 5000,
            backgroundColor: "linear-gradient(to right, #FF6B6B, #D50000)",
            close: true,
            gravity: "top",
            position: "center",
            stopOnFocus: true,
            className: "toast-error"
        }).showToast();
</script>

<style>
    /* Styles supplémentaires pour le design */
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f4f4;
    }

    .input-field {
        border-radius: 30px;
        padding-left: 40px;
        border: 1px solid #ddd;
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
        transition: background-color 0.3s ease;
        background-color: #0056b3;
        border: none;
    }

    .submit-button:hover {
        background-color: #004085;
    }

    /* Toastify personnalisé */
    .toast-error {
        font-weight: bold;
        font-size: 16px;
    }

    /* Bordure arrondie pour la carte */
    .card {
        border-radius: 15px;
        border: none;
    }

    /* Améliorer la présentation du formulaire */
    .form-control {
        font-size: 16px;
    }

    .form-label {
        color: #333;
    }

    .card-header {
        background-color: #0056b3;
        color: white;
        border-radius: 15px 15px 0 0;
        text-align: center;
    }
</style>
@endsection
