@extends('layouts.admin')

@section('title', 'Gestion des Émetteurs')
@section('page-title', 'Gestion des Émetteurs')

@section('contenu')
<div class="container mt-4">
    <div class="mt-4 row justify-content-center">
        <!-- Formulaire -->
        <div class="col-md-3">
            <div class="border-0 shadow-sm card custom-card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="emetteurForm"
                        action="{{ isset($emetteur) ? route('admin.emetteurs.update', $emetteur->id) : route('admin.emetteurs.store') }}"
                        method="POST">
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
                            <label for="reference_display">Référence</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="prefixReference">--</span>
                                </div>
                                <input type="text" class="form-control" id="reference_display" name="reference_display"
                                    value="{{ old('reference_display', isset($emetteur) ? preg_replace('/^(ER|ET)\s-\s/', '', $emetteur->reference) : '') }}"
                                    placeholder="Ex: 00001" maxlength="10" required>
                                <input type="hidden" name="reference" id="reference_full" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="id_localisation">Localisation</label>
                            <select name="localisation_id" required class="form-control">
                                <option value="">-- Choisir une localisation --</option>
                                @foreach ($localisations as $localisation)
                                    <option value="{{ $localisation->id }}" {{ isset($emetteur) && $emetteur->localisation_id == $localisation->id ? 'selected' : '' }}>{{ $localisation->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date_installation">Date d'installation</label>
                            <input type="date" id="date_installation" name="date_installation" class="form-control"
                                value="{{ isset($emetteur) ? $emetteur->date_installation : '' }}" required>
                        </div>

                        <div class="form-group">
                            <label for="derniere_maintenance">Dernière maintenance</label>
                            <input type="date" id="derniere_maintenance" name="derniere_maintenance" class="form-control"
                                value="{{ isset($emetteur) ? $emetteur->derniere_maintenance : '' }}">
                        </div>

                        <div class="form-group">
                            <label for="maintenance_prevue">Maintenance prévue</label>
                            <input type="date" id="maintenance_prevue" name="maintenance_prevue" class="form-control"
                                value="{{ isset($emetteur) ? $emetteur->maintenance_prevue : '' }}">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            @isset($emetteur) Modifier @else Ajouter @endisset
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste -->
        <div class="col-md-9">
            <div class="border-0 shadow-sm card custom-card">
                <div class="card-body">
                    <input type="text" id="search" class="mb-3 form-control" placeholder="Rechercher un émetteur...">
                    <div id="emetteursList">
                        <table class="table table-bordered table-striped">
                            <thead class="text-white" style="background-color: #003366;">
                                <tr>
                                    <th>Référence</th>
                                    <th>Type</th>
                                    <th>Localisation</th>
                                    <th>Date d'installation</th>
                                    <th>Dernière maintenance</th>
                                    <th>Maintenance prévue</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($emetteurs) && $emetteurs->count() > 0)
                                    @foreach ($emetteurs as $emetteur)
                                        <tr>
                                            <td>{{ $emetteur->reference }}</td>
                                            <td>{{ ucfirst($emetteur->type) }}</td>
                                            <td>{{ $emetteur->localisation->nom }}</td>
                                            <td>{{ $emetteur->date_installation }}</td>
                                            <td>{{ $emetteur->derniere_maintenance ?? 'N/A' }}</td>
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
                                        <td colspan="7" class="text-center">Aucun émetteur trouvé.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <div class="mt-4 d-flex justify-content-center">
                            {!! $emetteurs->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        // Confirmation suppression
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Cette action est irréversible !",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Recherche/filtrage dynamique sur la table
        document.getElementById("search").addEventListener("keyup", function () {
            let filter = this.value.toLowerCase();
            document.querySelectorAll("#emetteursList tbody tr").forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(filter) ? "" : "none";
            });
        });

        // Référence dynamique
        const typeSelect = document.getElementById('type');
        const prefixSpan = document.getElementById('prefixReference');
        const referenceDisplay = document.getElementById('reference_display');
        const referenceFull = document.getElementById('reference_full');

        function updateReferenceFull() {
            let prefix = '';
            if (typeSelect.value === 'radio') prefix = 'ER - ';
            else if (typeSelect.value === 'television') prefix = 'ET - ';
            prefixSpan.textContent = prefix.trim();
            referenceFull.value = prefix + referenceDisplay.value.trim();
        }

        typeSelect.addEventListener('change', updateReferenceFull);
        referenceDisplay.addEventListener('input', updateReferenceFull);
        updateReferenceFull();

        // Validation côté client
        const form = document.getElementById('emetteurForm');
        form.addEventListener('submit', function (e) {
            const dateInstallation = new Date(document.getElementById('date_installation').value);
            const dateDerniereMaintenance = document.getElementById('derniere_maintenance').value ? new Date(document.getElementById('derniere_maintenance').value) : null;
            const dateMaintenancePrevue = document.getElementById('maintenance_prevue').value ? new Date(document.getElementById('maintenance_prevue').value) : null;

            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (dateDerniereMaintenance) {
                if (dateDerniereMaintenance > today) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: "La date de dernière maintenance ne peut pas être dans le futur."
                    });
                    return;
                }

                if (dateDerniereMaintenance < dateInstallation) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: "La date de dernière maintenance ne peut pas être antérieure à la date d'installation."
                    });
                    return;
                }
            }

            if (dateMaintenancePrevue) {
                if (dateMaintenancePrevue < dateInstallation) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: "La date de maintenance prévue ne peut pas être antérieure à la date d'installation."
                    });
                    return;
                }
            }
        });
    });
</script>
@endsection
