@extends('layouts.admin')

@section('title', 'Gestion des Techniciens')
@section('page-title', 'Gestion des Techniciens')

@section('contenu')
<div class="container mt-4">
    <div class="border-0 shadow-sm card rounded-4">
        <div class="bg-white card-header border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary">Liste des Techniciens</h5>
            {{-- Option d'ajout --}}
            <!-- <a href="#" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle"></i> Ajouter</a> -->
        </div>

        <div class="card-body bg-light rounded-bottom">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table mb-0 overflow-hidden align-middle table-striped table-hover rounded-3">
                    <thead class="text-center table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($techniciens as $technicien)
                            <tr class="text-center">
                                <td class="fw-semibold">{{ $technicien->name }}</td>
                                <td>{{ $technicien->email }}</td>
                                <td>
                                    <span>{{ ucfirst($technicien->role) }}</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="confirmDelete({{ $technicien->id }})">
                                        Supprimer
                                    </button>
                                    <form id="delete-form-{{ $technicien->id }}"
                                          action="{{ route('admin.techniciens.destroy', $technicien->id) }}"
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted fst-italic">Aucun technicien trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection
