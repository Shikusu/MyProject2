@extends('layouts.admin')

@section('title', 'Gestion des Localisations')

@section('page-title', 'Gestion des Localisations')

@section('contenu')
<style>
    .pagination {
        justify-content: center;
    }

    .pagination .page-link {
        padding: 4px 8px;
        font-size: 16px;
        border: 1px solid #007BFF;
        color: #007BFF;
    }

    .pagination .page-item.active .page-link {
        background-color: #007BFF;
        border-color: #007BFF;
        color: white;
    }

    .pagination .page-link:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        color: white;
    }
</style>

<div class="container mt-4">
    <div class="mt-4 row justify-content-center">
        <!-- Form Section -->
        <div class="col-md-4">
            <div class="border-0 shadow-sm card custom-card">
                <div class="card-body">
                    <h4 class="mb-4" style="color: #00703C;">
                        {{ isset($localisation) ? 'Modifier la localisation' : 'Ajouter une localisation' }}
                    </h4>
                    <form
                        action="{{ isset($localisation) ? route('admin.localisations.update', $localisation->id) : route('admin.localisations.store') }}"
                        method="POST">
                        @csrf
                        @isset($localisation)
                        @method('PUT')
                        @endisset

                        <div class="mb-3">
                            <label for="nomLocalisation" class="form-label">Nom de la localisation</label>
                            <input
                                type="text"
                                name="nom"
                                id="nomLocalisation"
                                class="form-control @error('nom') is-invalid @enderror"
                                required
                                value="{{ old('nom', $localisation->nom ?? '') }}">
                            @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn {{ isset($localisation) ? 'btn-success' : 'btn-primary' }} w-100">
                            {{ isset($localisation) ? 'Modifier' : 'Ajouter' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- List Section -->
        <div class="col-md-8">
            <div class="border-0 shadow-sm card custom-card">
                <div class="card-body">
                    <h4 class="mb-4" style="color: #003366;">Liste des localisations</h4>
                    <div id="localisationsList">
                        <table class="table table-bordered table-striped">
                            <thead style="background-color: #003366;" class="text-white">
                                <tr>
                                    <th>Nom</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($localisations as $localisation)
                                <tr>
                                    <td>{{ $localisation->nom }}</td>
                                    <td>
                                        <a href="{{ route('admin.localisations.edit', $localisation->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i> Modifier
                                        </a>
                                        <form action="{{ route('admin.localisations.destroy', $localisation->id) }}"
                                            method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                <i class="bi bi-trash3"></i> Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center">Aucune localisation trouvée</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $localisations->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ SweetAlert pour succès -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let successMessage = "{{ session('success') }}";
    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: '<h5 style="font-size: 16px;">' + successMessage + '</h5>',
            showConfirmButton: false,
            timer: 1500
        });
    }
</script>

<!-- ✅ SweetAlert pour confirmation de suppression -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action est irréversible !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
