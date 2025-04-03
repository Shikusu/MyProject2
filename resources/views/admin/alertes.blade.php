@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Gestion des Alertes</h2>
    <div class="row">
        <!-- Formulaire à gauche -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Ajouter une Alerte</div>
                <div class="card-body">
                    <form id="alerte-form" action="{{ route('admin.alertes.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="alerte-type" class="form-label">Type d'Alerte</label>
                            <select id="alerte-type" name="type" class="form-select" required>
                                <option value="Panne Matérielle">Panne Matérielle</option>
                                <option value="Problème Réseau">Problème Réseau</option>
                                <option value="Maintenance Prévue">Maintenance Prévue</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="alerte-message" class="form-label">Message</label>
                            <textarea id="alerte-message" name="message" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submit-btn">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tableau à droite -->
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="alertes-table">
                    @foreach($alertes as $alerte)
                    <tr id="alerte-{{ $alerte->id }}">
                        <td>{{ $alerte->type }}</td>
                        <td>{{ $alerte->message }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editAlerte('{{ $alerte->id }}' , '{{ $alerte->type }}', '{{ $alerte->message }}')">
                                <i class="fas fa-edit"></i> Modifier
                            </button>
                            <form action="{{ route('admin.alertes.destroy', $alerte->id) }}" method="POST" style="display:inline;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            {{ $alertes->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Form submission
        $('#alerte-form').submit(function(event) {
            event.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        let newRow = `<tr id="alerte-${response.alerte.id}">
                                    <td>${response.alerte.type}</td>
                                    <td>${response.alerte.message}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" onclick="editAlerte(${response.alerte.id}, '${response.alerte.type}', '${response.alerte.message}')">
                                            <i class="fas fa-edit"></i> Modifier
                                        </button>
                                        <form action="/admin/alertes/${response.alerte.id}" method="POST" style="display:inline;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </td>
                                </tr>`;
                        $('#alertes-table').append(newRow);
                        $('#alerte-form')[0].reset();
                        Swal.fire('Succès', 'Alerte ajoutée avec succès!', 'success');
                    }
                },
                error: function() {
                    Swal.fire('Erreur', 'Une erreur est survenue.', 'error');
                }
            });
        });

        // Suppression avec confirmation SweetAlert
        $('.delete-form').submit(function(event) {
            event.preventDefault();
            let form = $(this);
            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: 'Vous ne pourrez pas revenir en arrière!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer!',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.unbind('submit').submit();
                }
            });
        });
    });

    function editAlerte(id, type, message) {
        Swal.fire({
            title: 'Modifier l\'alerte',
            html: `
                        <input type="text" id="type" class="swal2-input" value="${type}">
                        <textarea id="message" class="swal2-textarea">${message}</textarea>
                    `,
            showCancelButton: true,
            confirmButtonText: 'Sauvegarder',
            cancelButtonText: 'Annuler',
            preConfirm: () => {
                let updatedType = $('#type').val();
                let updatedMessage = $('#message').val();
                $.ajax({
                    url: '/admin/alertes/' + id,
                    type: 'PUT',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'type': updatedType,
                        'message': updatedMessage
                    },
                    success: function(response) {
                        if (response.success) {
                            $(`#alerte-${id} td:nth-child(1)`).text(updatedType);
                            $(`#alerte-${id} td:nth-child(2)`).text(updatedMessage);
                            Swal.fire('Succès', 'Alerte mise à jour!', 'success');
                        }
                    }
                });
            }
        });
    }
</script>
@endpush
@endsection