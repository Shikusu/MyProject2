@extends('layouts.technicien')

@section('title', 'Mon Profil')

@section('content')

    <div class="p-4 border-0 shadow card rounded-4">
        <div class="row align-items-center">
            <div class="text-center col-md-4">
                @if ($technicien->photo)
                    <img src="{{ asset('storage/' . $technicien->photo) }}" class="shadow rounded-circle" alt="Photo de profil"
                        style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($technicien->name) }}&background=0D8ABC&color=fff&size=140"
                        class="shadow rounded-circle" alt="Photo de profil"
                        style="width: 150px; height: 150px; object-fit: cover;">
                @endif
            </div>

            <div class="col-md-8">
                <h3 class="mb-3 fw-bold">{{ $technicien->name }} {{ $technicien->prenom }}</h3>
                <p><strong>Email :</strong> {{ $technicien->email }}</p>
                <p><strong>Rôle :</strong> {{ ucfirst($technicien->role ?? 'Technicien') }}</p>
                <a href="#" class="mt-3 btn btn-outline-primary" data-bs-toggle="modal"
                    data-bs-target="#editProfileModal">
                    Modifier mes infos
                </a>
            </div>
        </div>
    </div>

    <!-- Modal de modification du profil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('technicien.profile.updateProfile') }}" method="POST" enctype="multipart/form-data"
                class="shadow modal-content rounded-4">
                @csrf
                @method('PUT')

                <div class="text-white modal-header bg-primary rounded-top-4">
                    <h5 class="modal-title" id="editProfileModalLabel">
                        <i class="bi bi-pencil-square me-2"></i>Modifier mes informations
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fermer"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label"><i class="bi bi-person-fill me-1"></i>Nom</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $technicien->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="prenom" class="form-label"><i class="bi bi-person-lines-fill me-1"></i>Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom"
                            value="{{ old('prenom', $technicien->prenom) }}">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label"><i class="bi bi-envelope-fill me-1"></i>Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $technicien->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label"><i class="bi bi-image-fill me-1"></i>Photo de profil
                            (optionnel)</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                    </div>

                    <hr>

                    <a href="#" class="text-primary fw-semibold" data-bs-toggle="modal"
                        data-bs-target="#editPasswordModal" data-bs-dismiss="modal" style="cursor:pointer;">
                        <i class="bi bi-key-fill me-1"></i>Modifier le mot de passe
                    </a>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal secondaire : modification du mot de passe -->
    <div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <form action="{{ route('technicien.profile.update') }}" method="POST" class="shadow modal-content rounded-4">
                @csrf
                @method('PUT')

                <div class="text-white modal-header bg-primary rounded-top-4">
                    <h5 class="modal-title" id="editPasswordModalLabel">
                        <i class="bi bi-key-fill me-2"></i>Modifier mon mot de passe
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"
                        id="closePasswordModalBtn"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <input type="password" class="form-control" id="current_password" name="current_password"
                            required autocomplete="current-password">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required
                            autocomplete="new-password" minlength="8">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" required autocomplete="new-password" minlength="8">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Modifier
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Réouvrir modal profil quand on ferme modal mot de passe
        document.getElementById('editPasswordModal').addEventListener('hidden.bs.modal', function() {
            var editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
            editProfileModal.show();
        });

        // Réouvrir modal profil si erreurs de validation dans ce modal
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                var editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
                editProfileModal.show();
            @endif
        });
    </script>

@endsection

@push('scripts')
    <!-- Inclure SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: "{{ session('success') }}",
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'small-text-swal'
                }
            });
        @endif

        @if (session('password_error'))
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: "{{ session('password_error') }}",
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'small-text-swal'
                }
            });
        @endif
    </script>

    <style>
        .small-text-swal .swal2-html-container {
            font-size: 0.85rem;
        }
    </style>
@endpush
