@extends('layouts.admin')

@section('title', 'Gestion des Émetteurs')

@section('page-title', 'Gestion des Émetteurs')
@section('contenu')
<div class="container mt-4">
    <h1 class="text-center" style="font-size: 2.5rem; color: #00703C;">Gestion des Émetteurs</h1>

    <div class="mt-4 row justify-content-center">
        <!-- Formulaire d'ajout/modification -->
        <div class="col-md-3">
            <div class="border-0 shadow-sm card custom-card">
                <div class="card-body">
                    <form action="{{ isset($emetteur) ? route('admin.emetteurs.update', $emetteur->id) : route('admin.emetteurs.store') }}" method="POST">
                        @csrf
                        @isset($emetteur)
                        @method('PUT')
                        @endisset

                        <div class="form-group">
                            <label for="type">Type d'émetteur</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">Sélectionner le type</option>
                                <option value="radio" {{ isset($emetteur) && $emetteur->type == 'radio' ? 'selected' : '' }}>Radio</option>
                                <option value="television" {{ isset($emetteur) && $emetteur->type == 'television' ? 'selected' : '' }}>Télévision</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="id_localisation">Localisation</label>
                            <select name="localisation_id" required>
                                <option value="">-- Choisir une localisation --</option>
                                @foreach($localisations as $localisation)
                                    <option value="{{ $localisation->id }}">{{ $localisation->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date_installation">Date d'installation</label>
                            <input type="date" id="date_installation" name="date_installation" class="form-control"
                                value="{{ isset($emetteur) ? $emetteur->date_installation : '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="dernier_maintenance">Dernière maintenance</label>
                            <input type="date" id="dernier_maintenance" name="derniere_maintenance" class="form-control"
                                value="{{ isset($emetteur) ? $emetteur->dernier_maintenance : '' }}">
                        </div>

                        <div class="form-group">
                            <label for="maintenance_prevue">Maintenance prévue</label>
                            <input type="date" id="maintenance_prevue" name="maintenance_prevue" class="form-control"
                                value="{{ isset($emetteur) ? $emetteur->maintenance_prevue : '' }}">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            @isset($emetteur)
                            Modifier
                            @else
                            Ajouter
                            @endisset
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste des émetteurs -->
        <div class="col-md-9">
            <div class="border-0 shadow-sm card custom-card">
                <div class="card-body">
                    <!-- Barre de recherche -->
                    <input type="text" id="search" class="mb-3 form-control" placeholder="Rechercher un émetteur...">

                    <div id="emetteursList">
                        <table class="table table-bordered table-striped">
                            <thead class="text-white" style="background-color: #003366;">
                                <tr>
                                    <th class="col-2">Type</th>
                                    <th class="col-2">Localisation</th>
                                    <th class="col-2">Date d'installation</th>
                                    <th class="col-2">Dernière maintenance</th>
                                    <th class="col-2">Maintenance prévue</th>
                                    <th class="col-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($emetteurs) && $emetteurs->count() > 0)
                                @foreach ($emetteurs as $emetteur)
                                <tr>
                                    <td>{{ ucfirst($emetteur->type) }}</td>
                                    <td>{{ $emetteur->localisation->nom }}</td>
                                    <td>{{ $emetteur->date_installation }}</td>
                                    <td>{{ $emetteur->dernier_maintenance ?? 'N/A' }}</td>
                                    <td>{{ $emetteur->maintenance_prevue ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.emetteurs.edit', $emetteur->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.emetteurs.destroy', $emetteur->id) }}" method="POST" class="delete-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">Aucun émetteur trouvé.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="mt-4 d-flex justify-content-center">
                            {!! $emetteurs->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Affichage du message de succès
        if (session('success'))
            Swal.fire({
                title: "Succès !",
                text: "{{ session('success') }}",
                icon: "success",
                timer: 2000,
                showConfirmButton: false
            });

        // Confirmation de suppression
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: "Êtes-vous sûr ?",
                    text: "Cette action est irréversible !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Oui, supprimer !",
                    cancelButtonText: "Annuler"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });

    // Recherche dynamique
    document.getElementById("search").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll("#emetteursList tbody tr");

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? "" : "none";
        });
    });
</script>

@endsection

<style>
    .pagination {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
    }

    .pagination .page-item {
        margin: 0 3px !important;
    }

    .pagination .page-link {
        border-radius: 50% !important;
        padding: 8px 14px !important;
        background-color: #f8f9fa !important;
        color: #007BFF !important;
        border: 1px solid #007BFF !important;
        transition: background-color 0.3s ease, color 0.3s ease !important;
    }

    .pagination .page-link:hover {
        background-color: #007BFF !important;
        color: white !important;
    }

    .pagination .page-item.active .page-link {
        background-color: #007BFF !important;
        color: white !important;
        border-color: #007BFF !important;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #e9ecef !important;
        color: #6c757d !important;
        border-color: #e9ecef !important;
    }
</style>
