@extends('layouts.admin')

@section('title', 'Gestion des Localisations')

@section('content')
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
        <h1 class="text-center" style="font-size: 2.5rem; color: #00703C;">Gestion des Localisations</h1>

        <!-- Formulaire de création ou modification -->
        <div class="mt-4 row justify-content-center">
            <div class="col-md-4">
                <div class="border-0 shadow-sm card custom-card">
                    <div class="card-body">
                        <h4 class="mb-4" style="color: #00703C;">
                            @if (isset($localisation))
                                Modifier la localisation
                            @else
                                Ajouter une localisation
                            @endif
                        </h4>
                        <form
                            action="{{ isset($localisation) ? route('admin.localisations.update', $localisation->id) : route('admin.localisations.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($localisation))
                                @method('PUT')
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Nom de la localisation</label>
                                <input type="text" name="nom" class="form-control" id="nomLocalisation" required
                                    value="{{ old('nom', $localisation->nom ?? '') }}">
                            </div>
                            <button type="submit"
                                class="btn {{ isset($localisation) ? 'btn-success' : 'btn-primary' }} w-100">
                                @if (isset($localisation))
                                    Modifier
                                @else
                                    Ajouter
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Liste des localisations -->
            <div class="col-md-8">
                <div class="border-0 shadow-sm card custom-card">
                    <div class="card-body">
                        <h4 class="mb-4" style="color: #003366;">Liste des localisations</h4>
                        <div id="localisationsList">
                            <table class="table table-bordered table-striped">
                                <thead class="text-white" style="background-color: #003366;">
                                    <tr>
                                        <th>Nom</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($localisations as $localisation)
                                        <tr>
                                            <td>{{ $localisation->nom }}</td>
                                            <td>
                                                <!-- Bouton Modifier -->
                                                <a href="{{ route('admin.localisations.edit', $localisation->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil-square"></i> Modifier
                                                </a>
                                                <!-- Formulaire pour supprimer -->
                                                <form action="{{ route('admin.localisations.destroy', $localisation->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                        <i class="bi bi-trash3"></i> Supprimer
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <!-- Pagination -->
                                {{ $localisations->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script pour les alertes -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '<h5 style="font-size: 16px;">{{ session('success') }}</h5>',
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        @if ($errors->has('nom'))
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: '{{ $errors->first('nom') }}',
                showConfirmButton: true
            });
        @endif

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                let form = this.closest('form');
                Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: 'Cette action est irréversible !',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer !'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
