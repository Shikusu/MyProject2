@extends('layouts.admin')

@section('title', 'Gestion des Alertes')

@section('contenu')
<div class="container mt-5">
    <h1 class="mb-4">Gestion des Alertes</h1>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif


    <div class="row">
        {{-- Colonne gauche : Formulaire --}}
        <div class="col-md-4">
            <h4>Ajouter une nouvelle alerte</h4>
            <form method="POST" action="{{ route('admin.alertes.store') }}">
                @csrf
                <div class="mb-3">
                    <input type="text" class="form-control" id="type" name="type" required>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>

        {{-- Colonne droite : Liste des alertes --}}
        <div class="col-md-8">
            <h4>Liste des alertes</h4>
            @if($alertes->count() > 0)
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alertes as $alerte)
                            <tr id="alerte-{{ $alerte->id }}">
                                <td>{{ $alerte->type }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="editAlerte({{ $alerte->id }}, '{{ $alerte->type }}')">Modifier</button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteAlerte({{ $alerte->id }})">Supprimer</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $alertes->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    Aucune alerte trouvée.
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Scripts SweetAlert + jQuery --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    function editAlerte(id, currentType) {
        Swal.fire({
            title: 'Modifier le type d\'alerte',
            input: 'text',
            inputValue: currentType,
            showCancelButton: true,
            confirmButtonText: 'Mettre à jour',
            preConfirm: (newType) => {
                return fetch(`/admin/alertes/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({ type: newType })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#alerte-' + id + ' td:first').text(newType);
                        Swal.fire('Succès', 'Type mis à jour!', 'success');
                    } else {
                        Swal.fire('Erreur', 'Mise à jour échouée.', 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Erreur', 'Une erreur s\'est produite.', 'error');
                });
            }
        });
    }

    function deleteAlerte(id) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Oui, supprimer!',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/alertes/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#alerte-' + id).remove();
                        Swal.fire('Supprimé!', 'L\'alerte a été supprimée.', 'success');
                    } else {
                        Swal.fire('Erreur', 'Suppression échouée.', 'error');
                    }
                });
            }
        });
    }

</script>
@endsection
