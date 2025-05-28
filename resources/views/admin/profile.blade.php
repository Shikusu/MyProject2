@extends('layouts.admin')

@section('title', 'Mon Profil')

@section('contenu')
    <div class="p-4 border-0 shadow-sm card rounded-5" style="max-width: 700px; margin: auto;">
        <div class="row align-items-center g-4">
            <div class="text-center col-md-4">
                @if ($admin->photo)
                    <img src="{{ asset('storage/' . $admin->photo) }}" class="shadow rounded-circle" alt="Photo de profil"
                        style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=0D8ABC&color=fff&size=140"
                        class="shadow rounded-circle" alt="Photo de profil"
                        style="width: 150px; height: 150px; object-fit: cover;">
                @endif
            </div>

            <div class="col-md-8">
                <h2 class="mb-2 fw-bold">{{ $admin->name }} {{ $admin->prenom }}</h2>
                <p class="mb-1"><strong>Email :</strong> {{ $admin->email }}</p>
                <p class="mb-3"><strong>Rôle :</strong> {{ ucfirst($admin->role ?? 'Admin') }}</p>
                <button type="button" class="px-4 btn btn-outline-danger rounded-pill" data-bs-toggle="modal"
                    data-bs-target="#editProfileModal">
                    <i class="bi bi-pencil-square me-2"></i>Modifier mes infos
                </button>
            </div>
        </div>
    </div>

    <!-- Modal modification profil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.profile.updateProfile') }}" method="POST" enctype="multipart/form-data"
                class="shadow modal-content rounded-4">
                @csrf
                @method('PUT')

                <div class="text-white modal-header bg-danger rounded-top-4">
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
                            value="{{ old('name', $admin->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="prenom" class="form-label"><i class="bi bi-person-lines-fill me-1"></i>Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom"
                            value="{{ old('prenom', $admin->prenom) }}">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label"><i class="bi bi-envelope-fill me-1"></i>Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $admin->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="photo" class="form-label"><i class="bi bi-image-fill me-1"></i>Photo de profil
                            (optionnel)</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                    </div>

                    <hr>

                    <a href="#" class="text-danger fw-semibold d-inline-block" data-bs-toggle="modal"
                        data-bs-target="#editPasswordModal" data-bs-dismiss="modal" style="cursor:pointer;">
                        <i class="bi bi-key-fill me-1"></i>Modifier le mot de passe
                    </a>
                </div>

                <div class="modal-footer">
                    <button type="button" class="px-4 btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Annuler
                    </button>
                    <button type="submit" class="px-4 btn btn-danger rounded-pill">
                        <i class="bi bi-save me-1"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal modification mot de passe -->
    <div class="modal fade" id="editPasswordModal" tabindex="-1" aria-labelledby="editPasswordModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.profile.updatePassword') }}" method="POST"
                class="shadow modal-content rounded-4">
                @csrf
                @method('PUT')

                <div class="text-white modal-header bg-danger rounded-top-4">
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
                            required autocomplete="current-password" autofocus>
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
                    <button type="button" class="px-4 btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Annuler
                    </button>
                    <button type="submit" class="px-4 btn btn-danger rounded-pill">
                        <i class="bi bi-check-circle me-1"></i>Modifier
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var passwordModalEl = document.getElementById('editPasswordModal');
        passwordModalEl.addEventListener('hidden.bs.modal', function() {
            var editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
            editProfileModal.show();
        });

        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                var editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
                editProfileModal.show();
            @endif
        });
    </script>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: "{{ session('success') }}",
                timer: 1800,
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
                timer: 3500,
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
            font-size: 0.9rem;
        }

        .profile-photo-wrapper {
            width: 150px;
            height: 150px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .profile-photo-wrapper:hover {
            transform: scale(1.07);
        }

        .profile-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-initials {
            user-select: none;
        }
    </style>
@endpush
