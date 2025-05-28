@extends('layouts.technicien')

@section('title', 'Émetteurs en suivi')

@section('content')
    <div class="border-0 shadow-sm card rounded-4">
        <div class="bg-white border-0 card-header rounded-top-4 d-flex justify-content-between align-items-center">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th> Localisation</th>
                            <th> Type</th>
                            <th> Statut</th>
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($emetteurs as $emetteur)
                        <tr>
                            <td>{{ $emetteur->localisation?->nom ?? 'Non défini' }}</td>
                            <td>{{ ucfirst($emetteur->type) }}</td>
                            <td>
                                @php
                                    $status = $emetteur->status;
                                    $class = match($status) {
                                        'Actif' => 'success',
                                        'En panne' => 'danger',
                                        'En cours de réparation' => 'warning text-dark',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $class }} rounded-pill">{{ $status }}</span>
                            </td>
                            <td>
                                <button class="px-3 btn btn-outline-primary btn-sm rounded-pill"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailsModal"
                                    data-id="{{ $emetteur->id }}"
                                    data-localisation="{{ $emetteur->localisation->nom ?? 'Non défini' }}"
                                    data-type="{{ $emetteur->type }}"
                                    data-installation="{{ $emetteur->date_installation }}"
                                    data-maintenance="{{ $emetteur->derniere_maintenance }}"
                                    data-maintenance-prevue="{{ $emetteur->maintenance_prevue }}"
                                    data-status="{{ $emetteur->status }}">
                                    Voir Détails
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<!-- Modal Détails -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="shadow-lg modal-content rounded-4">
            <div class="modal-header bg-light rounded-top-4">
                <h5 class="modal-title text-primary" id="detailsModalLabel">📋 Détails de l'Émetteur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <ul class="mb-0 list-unstyled">
                    <li><strong> Localisation :</strong> <span id="modalLocalisation"></span></li>
                    <li><strong> Type :</strong> <span id="modalType"></span></li>
                    <li><strong> Installation :</strong> <span id="modalInstallation"></span></li>
                    <li><strong> Dernière maintenance :</strong> <span id="modalMaintenance"></span></li>
                    <li id="Bye"><strong> Maintenance prévue :</strong> <span id="modalMaintenancePrevue"></span></li>
                    <li><strong> Statut :</strong> <span id="modalStatus" class="badge"></span></li>
                </ul>
            </div>
            <div class="modal-footer bg-light rounded-bottom-4">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Fermer</button>
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
            var localisation = button.getAttribute("data-localisation");
            var type = button.getAttribute("data-type");
            var installation = button.getAttribute("data-installation");
            var maintenance = button.getAttribute("data-maintenance");
            var maintenancePrevue = button.getAttribute("data-maintenance-prevue");
            var status = button.getAttribute("data-status");

            document.getElementById("modalLocalisation").textContent = localisation;
            document.getElementById("modalType").textContent = type;
            document.getElementById("modalInstallation").textContent = installation;
            document.getElementById("modalMaintenance").textContent = maintenance;

            if (maintenancePrevue) {
                document.getElementById("Bye").style.display = "block";
                document.getElementById("modalMaintenancePrevue").textContent = maintenancePrevue;
            } else {
                document.getElementById("Bye").style.display = "none";
            }

            var modalStatus = document.getElementById("modalStatus");
            modalStatus.textContent = status;
            modalStatus.className = "badge rounded-pill";

            switch (status) {
                case 'Actif':
                    modalStatus.classList.add("bg-success");
                    break;
                case 'En panne':
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
