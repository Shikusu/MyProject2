
@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Liste des Stations</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Type</th>
                <th>Localisation</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stations as $station)
            <tr>
                <td>{{ $station->type }}</td>
                <td>{{ $station->localisation->nom }}</td>
                <td>
                    <span class="badge {{ $station->statut == 'En panne' ? 'bg-danger' : 'bg-success' }}">
                        {{ $station->statut }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $station->id }}">
                        Détails
                    </button>
                </td>
            </tr>

            <!-- Modal Détails -->
            <div class="modal fade" id="detailsModal{{ $station->id }}" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailsModalLabel">Détails de la Station</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Type :</strong> {{ $station->type }}</p>
                            <p><strong>Localisation :</strong> {{ $station->localisation->nom }}</p>
                            <p><strong>Date d'installation :</strong> {{ $station->date_installation }}</p>
                            <p><strong>Dernière maintenance :</strong> {{ $station->derniere_maintenance }}</p>
                            <p><strong>Maintenance prévue :</strong> {{ $station->maintenance_prevue }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
