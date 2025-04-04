@extends('layouts.admin')

@section('title', 'Gestion des interventions')

@section('content')
<div class="container">
    <h2>Gestion des interventions</h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
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
                    <td>{{ $emetteur->status!="panne"?$emetteur->status :"En panne" }}</td>
                    <td>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#interventionModal-{{ $emetteur->id }}">
                            Voir les détails
                        </button>
                        <!-- Modal pour afficher les détails de l'émetteur -->
                        <div class="modal fade" id="interventionModal-{{ $emetteur->id }}" tabindex="-1" aria-labelledby="interventionModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Détails de l'émetteur</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.interventions.declencherPanne', $emetteur->id) }}" method="POST">
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
                                                <p>{{ $emetteur->dernier_maintenance }}</p>
                                            </div>
                                            @if ($emetteur->status=="active")
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Date de la panne</strong></label>
                                                <input type="date" class="form-control" name="date_panne" id="date_panne"
                                                    max="<?php echo date('Y-m-d'); ?>" required>
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
                                            <button type="submit" class="btn btn-danger">Déclencher panne</button>
                                            @else
                                            <div class="mb-3">
                                                <label class="form-label"><strong>Maintenance prévue</strong></label>
                                                <p>{{ $emetteur->maintenance_prevue}}</p>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const datePanneInput = document.getElementById('date_panne');
        if (datePanneInput) {
            const today = new Date().toISOString().split('T')[0];
            datePanneInput.setAttribute('max', today);

            datePanneInput.addEventListener('change', function() {
                if (this.value > today) {
                    alert('La date de panne ne peut pas être ultérieure à aujourd\'hui');
                    this.value = today;
                }
            });
        }
    });
</script>
@endsection