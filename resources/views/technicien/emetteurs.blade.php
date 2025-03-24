@extends('layouts.technicien')

@section('title', 'Émetteurs en Suivi - ORTM')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Liste des Émetteurs</h3>
                    <div class="notification-icon">

                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Localisation</th>
                                <th>Type</th>
                                <th>Date d'installation</th>
                                <th>Date de dernière maintenance</th>
                                <th>Prochaine maintenance prévue</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emetteurs as $emetteur)
                                <tr>
                                    <td>{{ $emetteur->localisation->nom }}</td>
                                    <td>{{ $emetteur->type }}</td>
                                    <td>{{ $emetteur->date_installation }}</td>
                                    <td>{{ $emetteur->dernier_maintenance }}</td>
                                    <td>{{ $emetteur->maintenance_prevue }}</td>
                                    <td>
                                        <!-- Action de suivi -->
                                        <a href="#" class="btn btn-success">
                                            Suivi de l'intervention
                                        </a>

                                        <!-- Action pour les alertes -->
                                        <a href="#" class="btn btn-danger">
                                            Alertes
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
