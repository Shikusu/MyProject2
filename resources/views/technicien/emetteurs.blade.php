@extends('layouts.technicien')

@section('title', 'Émetteurs en Suivi - ORTM')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Liste des Émetteurs</h3>
                <div class="notification-icon"></div>
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
                            <th>Statut</th>
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
                            <td>{{ $emetteur->maintenance_prevue!=null ?$emetteur->maintenance_prevue :"------" }}</td>
                            <td>
                                @if ($emetteur->status == 'active')
                                <span class="badge bg-success">Actif</span>
                                @elseif($emetteur->status == 'panne')
                                <span class="badge bg-danger">En Panne</span>
                                @elseif($emetteur->status == 'En cours de réparation')
                                <span class="badge bg-warning text-dark">En cours de réparation</span>
                                @else
                                <span class="badge bg-secondary">Non défini</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#detailsModal" data-id="{{ $emetteur->id }}"
                                    data-localisation="{{ $emetteur->localisation->nom }}"
                                    data-type="{{ $emetteur->type }}"
                                    data-installation="{{ $emetteur->date_installation }}"
                                    data-maintenance="{{ $emetteur->dernier_maintenance }}"
                                    @if ($emetteur->status != 'active')
                                    data-maintenance-prevue="{{ $emetteur->maintenance_prevue }}"
                                    @endif
                                    data-status="{{ $emetteur->status }}">
                                    Détails
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Détails -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsModalLabel">Détails de l'Émetteur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Localisation :</strong> <span id="modalLocalisation"></span></p>
                <p><strong>Type :</strong> <span id="modalType"></span></p>
                <p><strong>Date d'installation :</strong> <span id="modalInstallation"></span></p>
                <p><strong>Date de dernière maintenance :</strong> <span id="modalMaintenance"></span></p>
                <p id="Bye"><strong>Prochaine maintenance prévue :</strong> <span id="modalMaintenancePrevue"></span></p>
                <p><strong>Statut :</strong> <span id="modalStatus" class="badge"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var detailsModal = document.getElementById("detailsModal");

        detailsModal.addEventListener("show.bs.modal", function(event) {
            var button = event.relatedTarget;

            // Récupération des données
            var localisation = button.getAttribute("data-localisation");
            var type = button.getAttribute("data-type");
            var installation = button.getAttribute("data-installation");
            var maintenance = button.getAttribute("data-maintenance");
            var maintenancePrevue = button.getAttribute("data-maintenance-prevue");
            var status = button.getAttribute("data-status");

            // Mise à jour des informations dans le modal
            document.getElementById("modalLocalisation").textContent = localisation;
            document.getElementById("modalType").textContent = type;
            document.getElementById("modalInstallation").textContent = installation;
            document.getElementById("modalMaintenance").textContent = maintenance;
            if (maintenancePrevue != null) {
                document.getElementById("Bye").style.display = "block";
                document.getElementById("modalMaintenancePrevue").style.display = "inline";
                document.getElementById("modalMaintenancePrevue").textContent = maintenancePrevue;
            } else {
                document.getElementById("Bye").style.display = "none";
                document.getElementById("modalMaintenancePrevue").style.display = "none";
            }
            // Mise à jour du statut avec une couleur
            var modalStatus = document.getElementById("modalStatus");
            modalStatus.textContent = status;

            // Réinitialisation des classes de couleur
            modalStatus.className =
                "badge"; // On réinitialise les classes du badge avant de les ajouter.

            // Application de la couleur selon le statut
            switch (status) {
                case 'active':
                    modalStatus.classList.add("bg-success");
                    break;
                case 'panne':
                    modalStatus.classList.add("bg-danger");
                    break;
                case 'En cours de réparation':
                    modalStatus.classList.add("bg-warning", "text-dark");
                    break;
                default:
                    modalStatus.classList.add("bg-secondary");
                    break;
            }
        });
    });
</script>
@endsection