@extends('layouts.technicien')

@section('title', 'Tableau de Bord')

@section('content')
    <div class="p-5 container-fluid">

        <div class="row g-4">

            <!-- COLONNE GAUCHE: ÉMETTEURS + CALENDRIER empilés verticalement -->
            <div class="gap-4 col-lg-4 col-md-6 d-flex flex-column">

                <!-- CARD ÉMETTEURS -->
                <div class="flex-grow-0 shadow-sm card border-start-5 border-success">
                    <div class="card-body">
                        <h5 class="card-title d-flex align-items-center text-success">
                            <i class="bi bi-send-fill me-2"></i> Émetteurs
                        </h5>
                        <h3 class="display-6 text-success">{{ $nombreEmetteurs }}</h3>
                        <a href="{{ route('technicien.emetteurs') }}" class="mt-3 btn btn-outline-success btn-sm">→ Voir les émetteurs</a>
                    </div>
                </div>

                <!-- CALENDRIER DES MAINTENANCES -->
                <div class="shadow-sm card flex-grow-1">
                    <div class="p-3 card-body">
                        <h5 class="mb-3 card-title text-dark">
                            <i class="bi bi-calendar-event me-2"></i> Calendrier des maintenances & réparations
                        </h5>
                        <div id="calendar" style="height: 300px;"></div>
                    </div>
                </div>
            </div>

            <!-- COLONNE DROITE: STATISTIQUES -->
            <div class="col-lg-8 col-md-6 d-flex align-items-stretch">
                <div class="shadow-sm card w-100">
                    <div class="card-body">
                        <h5 class="card-title text-dark">
                            <i class="bi bi-bar-chart-line me-2"></i> Statut des émetteurs
                        </h5>
                        <canvas id="statusChart" style="height: 100%; width: 100%; max-height: 350px;"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Actifs', 'En panne', 'En cours de réparation'],
                datasets: [{
                    label: 'Statut des émetteurs',
                    data: [{{ $emetteursActifs }}, {{ $emetteursEnPanne }}, {{ $emetteursEnReparation }}],
                    backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                    borderColor: '#fff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
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
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>

    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                events: [
                    @foreach ($maintenancesProches as $emetteur)
                        @if ($emetteur->maintenance_prevue)
                        {
                            title: 'Maintenance - {{ $emetteur->type }} ({{ $emetteur->localisation->nom ?? 'Sans localisation' }})',
                            start: '{{ \Carbon\Carbon::parse($emetteur->maintenance_prevue)->format('Y-m-d') }}',
                            color: '#0d6efd'
                        },
                        @endif
                        @if ($emetteur->derniereIntervention && $emetteur->derniereIntervention->date_reparation)
                        {
                            title: 'Réparation - {{ $emetteur->type }} ({{ $emetteur->localisation->nom ?? 'Sans localisation' }})',
                            start: '{{ \Carbon\Carbon::parse($emetteur->derniereIntervention->date_reparation)->format('Y-m-d') }}',
                            color: '#ffc107'
                        },
                        @endif
                    @endforeach
                ],
            });
            calendar.render();
        });
    </script>
@endsection
