@extends('layouts.admin')

@section('title', 'Gestion des Pièces')

@section('content')
<style>
    /* Style pour la pagination */
    .pagination {
        justify-content: center;
        /* Centrer la pagination */
    }

    .pagination .page-link {
        padding: 4px 8px;
        font-size: 16px;
        border: 1px solid #007BFF;
        /* Bordure bleue */
        color: #007BFF;
        /* Texte bleu */
    }

    .pagination .page-item.active .page-link {
        background-color: #007BFF;
        /* Fond bleu pour l'élément actif */
        border-color: #007BFF;
        /* Bordure bleue pour l'élément actif */
        color: white;
        /* Texte blanc pour l'élément actif */
    }

    .pagination .page-link:hover {
        background-color: #0056b3;
        /* Bleu foncé au survol */
        border-color: #0056b3;
        /* Bordure bleue foncée au survol */
        color: white;
        /* Texte blanc au survol */
    }
</style>

<div class="container mt-4">
    <h1 class="text-center" style="font-size: 2.5rem; color: #00703C;">Gestion des Pièces</h1>

    <div class="mt-4 row justify-content-center">
        <div class="col-md-4">
            <div class="border-0 shadow-sm card custom-card">
                <div class="card-body">
                    <h4 class="mb-4" style="color: #00703C;">
                        @if (isset($piece))
                        Modifier la pièce
                        @else
                        Ajouter une pièce
                        @endif
                    </h4>
                    <form action="{{ isset($piece) ? route('admin.pieces.update', $piece->id) : route('admin.pieces.store') }}" method="POST">
                        @csrf
                        @if (isset($piece))
                        @method('PUT')
                        @endif
                        <div class="mb-3">
                            <label class="form-label">Nom de la pièce</label>
                            <input type="text" name="nom" class="form-control" placeholder="Nom de la pièce" required value="{{ old('nom', $piece->nom ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type de pièce</label>
                            <input type="text" name="type" class="form-control" placeholder="Type de la pièce" required value="{{ old('type', $piece->type ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantité</label>
                            <input type="number" name="quantite" class="form-control" placeholder="Quantité" required value="{{ old('quantite', $piece->quantite ?? 1) }}" min="1">
                        </div>
                        <button type="submit" class="btn {{ isset($piece) ? 'btn-success' : 'btn-primary' }} w-100">
                            @if (isset($piece))
                            Modifier
                            @else
                            Ajouter
                            @endif
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="border-0 shadow-sm card custom-card">
                <div class="card-body">
                    <h4 class="mb-4" style="color: #003366;">Liste des pièces</h4>

                    <input type="text" id="search" class="mb-3 form-control" placeholder="Rechercher une pièce...">

                    <div id="piecesList">
                        <table class="table table-bordered table-striped">
                            <thead class="text-white" style="background-color: #003366;">
                                <tr>
                                    <th>Nom</th>
                                    <th>Type</th>
                                    <th>Quantité</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pieces as $piece)
                                <tr>
                                    <td>{{ $piece->nom }}</td>
                                    <td>{{ $piece->type }}</td>
                                    <td>{{ $piece->quantite }}</td>
                                    <td>
                                        <a href="{{ route('admin.pieces.edit', $piece->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.pieces.destroy', $piece->id) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete(event)">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $pieces->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
<script>
    if (session('success')) {
        const val = session('success');
        Swal.fire({
            icon: 'success',
            title: '<h5 style="font-size: 16px;">' + val + '</h5>',
            showConfirmButton: false,
            timer: 1500
        });

    }



    function confirmDelete(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Supprimer ?',
            text: 'Cette action est irréversible.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) event.target.closest('form').submit();
        });
    }

    // Fonction de recherche des pièces
    document.getElementById('search').addEventListener('input', function(event) {
        let query = event.target.value.toLowerCase();
        let rows = document.querySelectorAll('#piecesList table tbody tr');
        rows.forEach(row => {
            let name = row.cells[0].textContent.toLowerCase();
            let type = row.cells[1].textContent.toLowerCase();
            if (name.includes(query) || type.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection