@extends('layouts.admin')

@section('title', 'Gestion des interventions')

@section('page-title', 'Gestion des interventions')

@section('contenu')
<div class="container mt-4">
    <div class="table-responsive">
        <table class="table align-middle table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Type</th>
                    <th>Localisation</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($emetteurs as $emetteur)
                <tr>
                    <td>{{ $emetteur->type }}</td>
                    <td>{{ $emetteur->localisation->nom ?? 'Non définie' }}</td>
                    <td>
                        @php $status = $emetteur->status; @endphp
                        @if ($status == 'Actif')
                            <span class="badge bg-success">Actif</span>
                        @elseif ($status == 'En panne')
                            <span class="badge bg-danger">En panne</span>
                        @elseif ($status == 'En cours de réparation')
                            <span class="badge bg-warning text-dark">En cours de réparation</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($status) }}</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                            data-bs-target="#interventionModal-{{ $emetteur->id }}">
                            Voir les détails
                        </button>

                        <!-- Modal pour afficher les détails de l'émetteur -->
                        <div class="modal fade" id="interventionModal-{{ $emetteur->id }}" tabindex="-1"
                            aria-labelledby="interventionModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Détails de l'émetteur</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.interventions.declencherPanne', $emetteur->id) }}"
                                            method="POST">
                                            @csrf

                                            <div class="mb-3">
                                                <label class="form-label"><strong>Type</strong></label>
                                                <p>{{ $emetteur->type }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Localisation</strong></label>
                                                <p>{{ $emetteur->localisation->nom ?? 'Non définie' }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Date d'installation</strong></label>
                                                <p>{{ $emetteur->date_installation }}</p>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Dernière maintenance</strong></label>
                                                <p>{{ $emetteur->derniere_maintenance }}</p>
                                            </div>

                                            @if ($emetteur->status == "Actif")
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Date de la panne</strong></label>
                                                <input type="date" class="form-control"
                                                    name="date_panne"
                                                    id="date_panne_{{ $emetteur->id }}"
                                                    max="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Message</strong></label>
                                                <textarea name="message" class="form-control" rows="3" required></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Type d'alerte</strong></label>
                                                <select name="type_alerte" class="form-select" required>
                                                    @foreach ($alertesTypes as $type)
                                                    <option value="{{ $type }}">{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-danger w-100">Déclencher panne</button>
                                            @else
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Maintenance prévue</strong></label>
                                                <p>{{ $emetteur->maintenance_prevue }}</p>
                                            </div>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Script JS pour la validation côté client -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0];
        document.querySelectorAll("input[type='date'][id^='date_panne_']").forEach(input => {
            input.setAttribute('max', today);
            input.addEventListener('change', function () {
                if (this.value > today) {
                    alert("La date de panne ne peut pas être ultérieure à aujourd'hui.");
                    this.value = today;
                }
            });
        });
    });
</script>
@if (session('success'))
<script>
    new Noty({
        type: 'success',
        layout: 'bottomRight',
        theme: 'relax', // Tu peux aussi tester 'sunset' ou 'relax'
        text: "{{ session('success') }}",
        timeout: 3000,
        progressBar: true,
        theme: 'mint',
    }).show();
</script>
@endif

@endsection
