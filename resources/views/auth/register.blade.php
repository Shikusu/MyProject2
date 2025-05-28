@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div class="min-vh-100 d-flex justify-content-center align-items-center" style="font-family: 'Segoe UI', sans-serif;">
        <div class="p-4 shadow-lg card" style="max-width: 900px; width: 100%; border-radius: 20px;">
            <div class="row g-0">
                <!-- Formulaire -->
                <div class="px-5 py-4 col-md-7">
                    <h3 class="mb-4 text-center fw-bold text-primary">Créer un compte</h3>

                    <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nom</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" id="name" class="form-control form-white"
                                           placeholder="Nom" value="{{ old('name') }}" required>
                                </div>
                                @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="prenom" class="form-label">Prénom</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="prenom" id="prenom" class="form-control form-white"
                                           placeholder="Prénom" value="{{ old('prenom') }}">
                                </div>
                                @error('prenom')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Adresse e-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" id="email" class="form-control form-white"
                                           placeholder="email@example.com" value="{{ old('email') }}" required>
                                </div>
                                @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="matricule" class="form-label">Matricule</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-hash"></i></span>
                                    <input type="text" name="matricule" id="matricule" class="form-control form-white"
                                           placeholder="Matricule unique" value="{{ old('matricule') }}" required>
                                </div>
                                @error('matricule')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo (optionnel)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-image"></i></span>
                                <input type="file" name="photo" id="photo" class="form-control form-white">
                            </div>
                            @error('photo')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control form-white"
                                           placeholder="Mot de passe" required>
                                </div>
                                @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirmer</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="form-control form-white" placeholder="Confirmez le mot de passe" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Rôle</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                <select name="role" id="role" class="form-select form-white" required>
                                    <option value="technicien" {{ old('role') == 'technicien' ? 'selected' : '' }}>Technicien</option>
                                    @if (!$adminExists)
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    @endif
                                </select>
                            </div>
                            @error('role')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold" id="registerButton">
                                <span id="register-text"><i class="bi bi-person-plus me-2"></i> S'inscrire</span>
                                <span id="register-spinner" class="spinner-border spinner-border-sm ms-2 d-none"
                                      role="status" aria-hidden="true"></span>
                            </button>
                        </div>

                        <p class="mt-3 mb-0 text-center">
                            Vous avez déjà un compte ?
                            <a href="{{ route('login') }}" class="text-decoration-none text-primary fw-bold">Connexion</a>
                        </p>
                    </form>
                </div>

                <!-- Logo -->
                <div class="bg-white col-md-5 d-flex align-items-center justify-content-center rounded-end">
                    <img src="{{ asset('images/logo-ORTM.png') }}" alt="Logo ORTM" class="img-fluid" style="max-height: 220px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Toastify JS -->
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    @if (session('error'))
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 5000,
                gravity: "top",
                position: "center",
                backgroundColor: "#e53935",
                close: true
            }).showToast();
        </script>
    @endif

    @if (session('success'))
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 5000,
                gravity: "top",
                position: "center",
                backgroundColor: "#28a745",
                close: true
            }).showToast();
        </script>
    @endif

    <script>
        document.getElementById('registerButton').addEventListener('click', function () {
            const text = document.getElementById('register-text');
            const spinner = document.getElementById('register-spinner');
            text.classList.add('d-none');
            spinner.classList.remove('d-none');
        });
    </script>

    <style>
        .card {
            border: none;
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .form-white {
            background-color: #ffffff !important;
            border: 1px solid #ccc;
            color: #000;
        }

        .form-white:focus {
            background-color: #ffffff;
            border-color: #007bff;
            box-shadow: none;
        }

        .input-group-text {
            background-color: #ffffff;
            border: 1px solid #ccc;
            color: #555;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-label {
            font-weight: 600;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
