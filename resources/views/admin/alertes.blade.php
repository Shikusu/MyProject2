@extends('layouts.admin')

@section('title', 'Gestion des Alertes')

@section('page-title', 'Gestion des Alertes')

@section('contenu')
<div class="container mt-4">
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
        {{-- Formulaire --}}
        <div class="col-md-4">
            <h4>Ajouter une nouvelle alerte</h4>
            <form method="POST" action="{{ route('admin.alertes.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="type">Type d'Alerte</label>
                    <input type="text" class="form-control @error('typeA') is-invalid @enderror" id="type" name="typeA" required>
                    @error('typeA')
                        <div class="mt-1 text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>

        {{-- Liste des alertes --}}
        <div class="col-md-8">
            <h4>Liste des alertes</h4>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="alertesTableBody">
                    @foreach($alertes as $alerte)
                        <tr id="alerte-{{ $alerte->id }}">
                            <td>{{ $alerte->typeA }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning"
                                    onclick="editAlerte({{ $alerte->id }}, '{{ $alerte->typeA }}')"><i class="bi bi-pencil-square"></i> Modifier</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteAlerte({{ $alerte->id }})"><i class="bi bi-trash3"></i> Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $alertes->links() }}
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert + jQuery --}}
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
                    body: JSON.stringify({ typeA: newType })
                })
                .then(async response => {
                    const data = await response.json();
                    if (!response.ok) {
                        if (data.errors && data.errors.typeA) {
                            throw new Error(data.errors.typeA[0]);
                        }
                        throw new Error(data.message || 'Une erreur s\'est produite.');
                    }
                    return data;
                })
                .then(data => {
                    $('#alerte-' + id + ' td:first').text(data.alerte.typeA);
                    Swal.fire('Succès', 'Type mis à jour!', 'success');
                })
                .catch(error => {
                    Swal.fire('Erreur', error.message, 'error');
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
