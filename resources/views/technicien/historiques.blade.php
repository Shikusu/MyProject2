@extends('layouts.technicien')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Historique des Interventions</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Type d'Émetteur</th>
                <th>Localisation</th>
                <th>Message</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($interventions as $intervention)
            <tr>
                <td>{{ $intervention->emetteur->type }}</td>
                <td>{{ $intervention->emetteur->localisation->nom }}</td>
                <td>{{ $intervention->message }}</td>
                <td>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reparationModal"
                        id="repair-btn-{{ $intervention->id }}" data-id="{{ $intervention->id }}"
                        data-emetteur="{{ $intervention->emetteur->type }}"
                        data-localisation="{{ $intervention->emetteur->localisation->nom }}"
                        data-type_alerte="{{ $intervention->alerte ? $intervention->alerte->type : 'Non spécifié' }}"
                        data-message="{{ $intervention->message }}"
                        data-date_installation="{{ $intervention->emetteur->date_installation }}"
                        data-derniere_maintenance="{{ $intervention->emetteur->derniere_maintenance }}"
                        data-date_panne="{{ $intervention->date_panne }}">
                        Réparer
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal de réparation -->
<div class="modal fade" id="reparationModal" tabindex="-1" aria-labelledby="reparationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reparationModalLabel">Détails de l'Émetteur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reparationForm">
                    <div class="mb-3">
                        <label class="form-label">Type d'Émetteur</label>
                        <input type="text" class="form-control" id="emetteur" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Localisation</label>
                        <input type="text" class="form-control" id="localisation" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type d'Alerte</label>
                        <input type="text" class="form-control" id="type_alerte" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="2" disabled></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date d'Installation</label>
                        <input type="text" class="form-control" id="date_installation" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date de Dernière Maintenance</label>
                        <input type="text" class="form-control" id="derniere_maintenance" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date de Panne</label>
                        <input type="text" class="form-control" id="date_panne" disabled>
                    </div>

                    <!-- Description de la réparation -->
                    <div class="mb-3">
                        <label class="form-label">Description de la Réparation</label>
                        <textarea class="form-control" id="description_reparation" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date de Réparation</label>
                        <input type="date" class="form-control" id="date_reparation">
                    </div>

                    <!-- Sélection des pièces -->
                    <div class="mb-3">
                        <label class="form-label">Pièces utilisées</label>
                        <div id="piecesContainer">
                            <div class="mb-2 input-group">
                                @if (isset($pieces) && $pieces->isNotEmpty())
                                <select class="form-select piece-select">
                                    <option value="">Sélectionner une pièce</option>
                                    @foreach ($pieces as $piece)
                                    <option value="{{ $piece->id }}">{{ $piece->nom }}</option>
                                    @endforeach
                                </select>
                                @else
                                <option disabled>Aucune pièce disponible</option>
                                @endif
                                <input type="number" class="form-control piece-quantite" placeholder="Quantité"
                                    min="1">
                                <button type="button" class="btn btn-danger remove-piece">X</button>
                            </div>
                        </div>
                        <button type="button" class="mt-2 btn btn-success" id="addPiece">+ Ajouter une pièce</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="saveRepair">Enregistrer la Réparation</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('[id^="repair-btn-"]').forEach(function(button) {
        button.addEventListener('click', function() {
            document.getElementById('emetteur').value = this.getAttribute('data-emetteur');
            document.getElementById('localisation').value = this.getAttribute('data-localisation');
            document.getElementById('type_alerte').value = this.getAttribute('data-type_alerte');
            document.getElementById('message').value = this.getAttribute('data-message');
            document.getElementById('date_installation').value = this.getAttribute('data-date_installation');
            document.getElementById('derniere_maintenance').value = this.getAttribute('data-derniere_maintenance');
            document.getElementById('date_panne').value = this.getAttribute('data-date_panne');
        });
    });

    // Ajouter une nouvelle ligne pour une pièce
    document.getElementById('addPiece').addEventListener('click', function() {
        var container = document.getElementById('piecesContainer');
        var newRow = document.createElement('div');
        newRow.classList.add('input-group', 'mb-2');
        newRow.innerHTML = `
                    <select class="form-select piece-select">
                        <option value="">Sélectionner une pièce</option>
                        @foreach ($pieces as $piece)
                            <option value="{{ $piece->id }}">{{ $piece->nom }}</option>
                        @endforeach
                    </select>
                    <input type="number" class="form-control piece-quantite" placeholder="Quantité" min="1">
                    <button type="button" class="btn btn-danger remove-piece">X</button>
                `;
        container.appendChild(newRow);
    });

    // Supprimer une pièce
    document.getElementById('piecesContainer').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-piece')) {
            event.target.parentElement.remove();
        }
    });

    // Sauvegarde de la réparation
    document.getElementById('saveRepair').addEventListener('click', function() {
        alert('Réparation enregistrée avec les pièces sélectionnées.');
    });
</script>
@yield('scripts')
@endsection
