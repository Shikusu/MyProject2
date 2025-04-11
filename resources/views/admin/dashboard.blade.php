@extends('layouts.admin')

@section('title', 'Tableau de Bord')
@section('page-title', 'Tableau de Bord')

@section('contenu')


    <div class="my-2 row g-3">
        <div class="col-md-2">
            <a href="{{ route('admin.emetteurs.index') }}" class="text-decoration-none">
                <div class="mb-3 text-white card"
                    style="background: linear-gradient(to right, #e74c3c, #c0392b); border: none;">
                    <div class="text-center card-header fw-bold">Nombre Total d'Émetteurs</div>
                    <div class="text-center card-body">
                        <h3 class="fs-3">
                            {{ $nombreEmetteursActifs + $nombreEmetteursPanne + $nombreEmetteursEnReparation }}
                        </h3>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="my-5 row">
        <div class="col-md-6">
            <h3 class="mb-3 fs-4">Répartition des Émetteurs</h3>
            <canvas id="emetteursChart"></canvas>
        </div>
    </div>

    @isset($notifs)
        <div class="my-3 row">
            <h3 class="mb-3 fs-4">Notifications</h3>
            <div class="col">
                <ul class="list-group">
                    @foreach ($notifs as $notif)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i
                                    class="bi bi-info-circle{{ $notif->est_vu == 0 ? '-fill text-primary' : ' text-secondary' }}"></i>
                                <span class="{{ $notif->est_vu == 0 ? 'fw-bold' : 'text-muted' }}">{{ $notif->message }}</span>
                            </div>
                            <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                        </li>
                    @endforeach
                    <a href="{{ route('admin.interventions.index') }}" class="mt-3 btn btn-primary">Voir toutes les alertes</a>
                </ul>
            </div>
        </div>
    @endisset
@endsection

@push('scripts')
    <script>
        // Graphe des émetteurs par statut
        var ctx = document.getElementById('emetteursChart').getContext('2d');
        var emetteursChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Actifs', 'En Panne', 'En Réparation'],
                datasets: [{
                    label: 'Répartition des Émetteurs',
                    data: [{{ $nombreEmetteursActifs }}, {{ $nombreEmetteursPanne }},
                        {{ $nombreEmetteursEnReparation }}
                    ],
                    backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                    borderColor: ['#155724', '#721c24', '#856404'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' émetteur(s)';
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
