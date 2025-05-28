@extends('layouts.admin')

@section('title', 'Tableau de Bord')
@section('page-title', 'Tableau de Bord')

@section('contenu')

    {{-- Bouton “Notifications récentes” --}}
    <div class="mb-3 d-flex justify-content-end">
        <button class="btn btn-primary position-relative" data-bs-toggle="modal" data-bs-target="#notifModal">
            Notifications récentes
            @if (isset($notifs) && $notifs->where('est_vu', 0)->count() > 0)
                <span
                    class="top-0 p-1 border position-absolute start-100 translate-middle bg-danger border-light rounded-circle"></span>
            @endif
        </button>
    </div>

    {{-- Cards compteur --}}
    <div class="mb-4 row g-4 justify-content-center">
        @php
            $stats = [
                [
                    'title' => 'Émetteurs Total',
                    'count' => $nombreEmetteursActifs + $nombreEmetteursPanne + $nombreEmetteursEnReparation,
                    'icon' => 'bi-broadcast',
                ],
                [
                    'title' => 'Localisations',
                    'count' => $nombreLocalisations,
                    'icon' => 'bi-geo-alt',
                ],
                [
                    'title' => 'Pièces',
                    'count' => $nombrePieces,
                    'icon' => 'bi-cpu',
                ],
                [
                    'title' => 'Alertes',
                    'count' => $nombreAlertes,
                    'icon' => 'bi-exclamation-triangle',
                ],
            ];
        @endphp

        @foreach ($stats as $stat)
            <div class="col-sm-6 col-md-4 col-lg-2">
                <div class="text-decoration-none">
                    <div class="border-0 shadow-sm card h-100">
                        <div class="text-center card-body">
                            <div class="mb-2">
                                <i class="bi {{ $stat['icon'] }} fs-3 text-primary"></i>
                            </div>
                            <div class="fw-semibold">{{ $stat['title'] }}</div>
                            <h4 class="m-0">{{ $stat['count'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Card nombre de techniciens --}}
        <div class="col-sm-6 col-md-4 col-lg-2">
            <div class="border-0 shadow-sm card h-100">
                <div class="text-center card-body">
                    <div class="mb-2">
                        <i class="bi bi-people-fill fs-3 text-primary"></i>
                    </div>
                    <div class="fw-semibold">Techniciens</div>
                    <h4 class="m-0">{{ $techniciens->count() }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphiques et tableau --}}
    <div class="row g-4">
        <div class="col-md-6">
            <div class="shadow-sm card w-100" style="max-height: 450px;">
                <div class="bg-white card-header fw-bold">
                    Répartition des Émetteurs
                </div>
                <div class="card-body d-flex align-items-center justify-content-center" style="height: 300px;">
                    <canvas id="emetteursChart" style="max-width: 80%; max-height: 80%;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="shadow-sm card" style="max-height: 450px;">
                <div class="bg-white card-header fw-bold">
                    Liste des Techniciens
                </div>
                <div class="card-body table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th><i class="bi bi-person-badge"></i> Nom</th>
                                <th><i class="bi bi-envelope"></i> Email</th>
                                <th><i class="bi bi-calendar-event"></i> Ajouté le</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($techniciens as $technicien)
                                <tr>
                                    <td>{{ $technicien->name }}</td>
                                    <td>{{ $technicien->email }}</td>
                                    <td>{{ $technicien->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Aucun technicien enregistré</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Liste des émetteurs --}}
    <div class="mt-4 row">
        <div class="col-12">
            <div class="shadow-sm card">
                <div class="bg-white card-header fw-bold">
                    Liste des Émetteurs installés
                </div>
                <div class="card-body table-responsive" style="max-height: 350px; overflow-y: auto;">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Référence</th>
                                <th>Type</th>
                                <th>Localisation</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($emetteurs as $emetteur)
                                <tr>
                                    <td>{{ $emetteur->reference }}</td>
                                    <td>{{ ucfirst($emetteur->type) }}</td>
                                    <td>{{ $emetteur->localisation->nom ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            if ($emetteur->status == 'Actif') {
                                                $badgeClass = 'success';
                                                $statusText = 'Actif';
                                            } elseif ($emetteur->status == 'En panne') {
                                                $badgeClass = 'danger';
                                                $statusText = 'En panne';
                                            } elseif ($emetteur->status == 'En cours de réparation') {
                                                $badgeClass = 'warning';
                                                $statusText = 'En cours réparation';
                                            } else {
                                                $badgeClass = 'secondary';
                                                $statusText = 'Inconnu';
                                            }
                                        @endphp
                                        <span class="badge bg-{{ $badgeClass }}">{{ $statusText }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucun émetteur enregistré</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if ($emetteurs->lastPage() > 1)
                        <nav aria-label="Page navigation" class="d-flex justify-content-center">
                            <ul class="pagination">
                                <li class="page-item {{ $emetteurs->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $emetteurs->previousPageUrl() }}" aria-label="Précédent">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>

                                @php
                                    $start = max($emetteurs->currentPage() - 1, 1);
                                    $end = min($start + 2, $emetteurs->lastPage());
                                    if ($end - $start < 2) {
                                        $start = max($end - 2, 1);
                                    }
                                @endphp

                                @for ($i = $start; $i <= $end; $i++)
                                    <li class="page-item {{ $emetteurs->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $emetteurs->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <li class="page-item {{ $emetteurs->currentPage() == $emetteurs->lastPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $emetteurs->nextPageUrl() }}" aria-label="Suivant">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Modal notifications --}}
    <div class="modal fade" id="notifModal" tabindex="-1" aria-labelledby="notifModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="text-white modal-header bg-primary">
                    <h5 class="modal-title"><i class="bi bi-bell-fill me-2"></i> Notifications</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    @if (isset($notifs) && $notifs->count() > 0)
                        <ul class="list-group">
                            @foreach ($notifs as $notif)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <i
                                            class="bi bi-info-circle{{ $notif->est_vu == 0 ? '-fill text-primary' : ' text-secondary' }}"></i>
                                        <span class="{{ $notif->est_vu == 0 ? 'fw-bold' : 'text-muted' }}">
                                            {{ $notif->message }}
                                        </span>
                                    </div>
                                    <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-3 text-end">
                            <a href="{{ route('admin.interventions.index') }}" class="btn btn-sm btn-outline-primary">
                                Voir toutes les alertes
                            </a>
                        </div>
                    @else
                        <p class="text-muted">Aucune notification pour le moment.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- Import Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Récupération des données du serveur injectées depuis le contrôleur Laravel
        const emetteursActifs = {{ $nombreEmetteursActifs ?? 0 }};
        const emetteursEnPanne = {{ $nombreEmetteursPanne ?? 0 }};
        const emetteursEnReparation = {{ $nombreEmetteursEnReparation ?? 0 }};

        const ctx = document.getElementById('emetteursChart').getContext('2d');

        const emetteursChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Actif', 'En panne', 'En réparation'],
                datasets: [{
                    label: 'Émetteurs',
                    data: [emetteursActifs, emetteursEnPanne, emetteursEnReparation],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.7)', // vert bootstrap success
                        'rgba(220, 53, 69, 0.7)', // rouge bootstrap danger
                        'rgba(255, 193, 7, 0.7)', // jaune bootstrap warning
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(255, 193, 7, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        enabled: true
                    }
                }
            }
        });
    </script>
@endpush
