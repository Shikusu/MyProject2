@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="shadow-lg card" style="width: 800px; border-radius: 15px;">
        <div class="row g-0">
            <!-- Colonne gauche : Formulaire -->
            <div class="p-5 col-md-6">
                <h2 class="mb-4 text-center" style="color: #333;">Créer un compte</h2>
                <form action="{{ route('register.submit') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="form-label">Nom complet :</label>
                        <input type="text" name="name" id="name" class="form-control input-field"
                            placeholder="Entrez votre nom" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
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
                            placeholder="Créez un mot de passe" required>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe :</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-field"
                            placeholder="Confirmer votre mot de passe" required>
                    </div>
                    <div class="mb-4">
                        <label for="role" class="form-label">Rôle :</label>
                        <select name="role" id="role" class="form-select">
                            <option value="technicien" {{ old('role') == 'technicien' ? 'selected' : '' }}>Technicien</option>
                            @if (!$adminExists)
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            @endif
                        </select>
                        @error('role')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100 submit-button">S'inscrire</button>
                    </div>
                </form>
                <p class="mt-3 text-center">
                    Vous avez déjà un compte ?
                    <a href="{{ route('login') }}" class="text-primary">Connectez-vous ici</a>.
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
    @if(session('error'))
    Toastify({
        text: '{{ session('
        error ') }}',
        duration: 5000,
        backgroundColor: "linear-gradient(to right, #FF6B6B, #D50000)",
        close: true,
        gravity: "top",
        position: "center",
        stopOnFocus: true,
        className: "toast-error"
    }).showToast();
    @endif
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
