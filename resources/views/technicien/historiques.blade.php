@extends('layouts.technicien')

@section('title', 'Signal Défaillant')

@section('content')
<div class="container mt-4">
    @if ($interventions->isEmpty())
        <div class="text-center alert alert-info">
            Aucune panne déclenchée pour le moment.
        </div>
    @else
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
                        <td>{{ $intervention->emetteur?->type ?? 'N/A' }}</td>
                        <td>{{ $intervention->emetteur?->localisation?->nom ?? 'N/A' }}</td>
                        <td>{{ $intervention->message }}</td>
                        <td>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reparationModal"
                                id="repair-btn-{{ $intervention->id }}"
                                data-id="{{ $intervention->id }}"
                                data-emetteur="{{ $intervention->emetteur?->type ?? '' }}"
                                data-localisation="{{ $intervention->emetteur?->localisation?->nom ?? '' }}"
                                data-type_alerte="{{ $intervention->type_alerte }}"
                                data-message="{{ $intervention->message }}"
                                data-date_installation="{{ $intervention->emetteur?->date_installation }}"
                                data-derniere_maintenance="{{ $intervention->emetteur?->derniere_maintenance }}"
                                data-date_panne="{{ $intervention->date_panne }}"
                                data-date_entree="{{ $intervention->date_entree }}">
                                Réparer
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<!-- Modal de réparation -->
<div class="modal fade" id="reparationModal" tabindex="-1" aria-labelledby="reparationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de l'Émetteur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
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
                        <label class="form-label">Dernière Maintenance</label>
                        <input type="text" class="form-control" id="derniere_maintenance" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date de Panne</label>
                        <input type="text" class="form-control" id="date_panne" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date d'entrée</label>
                        <input type="date" class="form-control" id="date_entree" name="date_entree" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description de la Réparation</label>
                        <textarea class="form-control" id="description_reparation" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date de Finition</label>
                        <input type="date" class="form-control" id="date_reparation">
                    </div>

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
                                <input type="number" class="form-control piece-quantite" placeholder="Quantité" min="1">
                                <button type="button" class="btn btn-danger remove-piece">X</button>
                            </div>
                        </div>
                        <button type="button" class="mt-2 btn btn-success" id="addPiece">+ Ajouter une pièce</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="saveRepair" data-id="">Lancer la Réparation</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('[id^="repair-btn-"]').forEach(button => {
        button.addEventListener('click', () => {
            document.getElementById('emetteur').value = button.dataset.emetteur || '';
            document.getElementById('localisation').value = button.dataset.localisation || '';
            document.getElementById('type_alerte').value = button.dataset.type_alerte || '';
            document.getElementById('message').value = button.dataset.message || '';
            document.getElementById('date_installation').value = button.dataset.date_installation || '';
            document.getElementById('derniere_maintenance').value = button.dataset.derniere_maintenance || '';
            document.getElementById('date_panne').value = button.dataset.date_panne || '';
            document.getElementById('date_entree').value = button.dataset.date_entree || '';
            document.getElementById('saveRepair').setAttribute('data-id', button.dataset.id);
        });
    });

    document.getElementById('addPiece').addEventListener('click', () => {
        let container = document.getElementById('piecesContainer');
        let newRow = document.createElement('div');
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

    document.getElementById('piecesContainer').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-piece')) {
            e.target.parentElement.remove();
        }
    });

    document.getElementById('saveRepair').addEventListener('click', () => {
        let id = document.getElementById('saveRepair').getAttribute('data-id');
        let dateReparation = document.getElementById('date_reparation').value;
        let description = document.getElementById('description_reparation').value;
        let dateReparationFait = new Date().toISOString().split('T')[0];

        let pieces = Array.from(document.querySelectorAll('.piece-select')).map(select => {
            let pieceId = select.value;
            let quantite = select.closest('.input-group').querySelector('.piece-quantite').value;
            return pieceId ? { id: pieceId, quantite } : null;
        }).filter(p => p !== null);

        if (!dateReparation) {
            new Noty({
                text: "Veuillez sélectionner une date de réparation.",
                type: 'warning',
                layout: 'bottomRight',
                timeout: 3000
            }).show();
            return;
        }

        fetch(`/interventions/${id}/lancement-reparation`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                date_reparation: dateReparation,
                date_reparation_fait: dateReparationFait,
                description: description,
                pieces: pieces
            })
        })
        .then(res => res.json())
        .then(data => {
            new Noty({
                text: data.message,
                type: 'success',
                layout: 'bottomRight',
                timeout: 3000
            }).show();
            setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            console.error(error);
            new Noty({
                text: "Erreur lors de l'envoi de la réparation.",
                type: 'error',
                layout: 'bottomRight',
                timeout: 3000
            }).show();
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date_reparation').setAttribute('min', today);
    });
</script>
@endsection
