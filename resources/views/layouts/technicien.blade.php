<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <link rel="stylesheet" href="{{ asset('css/bootstrap-5.3.1-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- JS de Bootstrap et Popper.js (nécessaire pour les modals) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



    <title>@yield('title', 'Dashboard Technicien') - {{ Auth::user()->name }}</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="pt-3 logo ms-5">
                <a href="#"><img src="{{ asset('images/logo-ORTM.png') }}" alt="Logo"></a>
            </div>
            <div class="my-3 list-group list-group-flush">
                <a href="{{ route('technicien.dashboard') }}" class="bg-transparent list-group-item active">
                    <i class="bi bi-house-door-fill me-2"></i> Dashboard
                </a>
                <a href="{{ route('technicien.emetteurs') }}" class="bg-transparent list-group-item list-group-item-action second-text fw-bold">
                    <i class="bi bi-radioactive me-2"></i> Émetteurs en Suivi
                </a>
                @isset($intervention) <!-- Vérifier si l'intervention est définie -->
                <a href="{{ route('technicien.reparations', ['id' => $intervention->id]) }}" class="bg-transparent list-group-item list-group-item-action second-text fw-bold">
                    <i class="bi bi-tools me-2"></i> Réparations
                </a>
                @endisset
                <a href="{{ route('technicien.historiques') }}" class="bg-transparent list-group-item list-group-item-action second-text fw-bold">
                    <i class="bi bi-file-earmark-text me-2"></i> Historique des Interventions
                </a>
                <a href="#" class="bg-transparent list-group-item list-group-item-action second-text fw-bold">
                    <i class="bi bi-person-circle me-2"></i> Profil
                </a>

                <!-- Bouton de Déconnexion -->
                <button type="button" class="bg-transparent list-group-item list-group-item-action text-danger fw-bold" id="logout-button">
                    <i class="bi bi-power me-2"></i> Déconnexion
                </button>

                <!-- Formulaire de Déconnexion -->
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <!-- Navbar Header -->
            <nav class="px-4 py-4 bg-transparent navbar navbar-expand-lg navbar-light d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="m-0 fs-2">@yield('title', 'Dashboard Technicien')</h2>
                </div>
                <div class="d-flex align-items-center">
                    <!-- Enhanced Notification Dropdown -->
                    @isset($notifs)
                    <div class="dropdown ms-3 me-3">
                        <button class="btn btn-light btn-sm position-relative rounded-circle shadow-sm p-2"
                            type="button" id="messageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-envelope fs-5 text-primary"></i>
                            @if($notifs->where('est_lu', 0)->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $notifs->where('est_lu', 0)->count() }}
                                <span class="visually-hidden">messages non lus</span>
                            </span>
                            @endif
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-0"
                            aria-labelledby="messageDropdown"
                            id="messageDropdownMenu"
                            style="min-width: 280px; max-height: 350px; overflow-y: auto;">

                            <!-- Notification Header -->
                            <li class="dropdown-header bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-primary">Notifications</span>
                                @if($notifs->where('est_lu', 0)->count() > 0)
                                <span class="badge bg-primary rounded-pill">{{ $notifs->where('est_lu', 0)->count() }}</span>
                                @endif
                            </li>

                            <div class="dropdown-divider m-0"></div>

                            <!-- Notifications List -->
                            @if(count($notifs) > 0)
                            @php $hasUnread = false; @endphp

                            @foreach($notifs as $notif)
                            @if($notif->est_lu != 1)
                            @php $hasUnread = true; @endphp
                            <li>
                                <a class="dropdown-item py-2 px-3 d-flex align-items-center {{ $notif->est_vu == 0 ? 'bg-light' : '' }}"
                                    href="{{ route('technicien.historiques') }}"
                                    data-id="{{ $notif->id }}"
                                    onclick="markAsRead(this)">
                                    <div class="me-2">
                                        <i class="bi bi-info-circle{{ $notif->est_vu == 0 ? '-fill text-primary' : ' text-secondary' }}"></i>
                                    </div>
                                    <div class="{{ $notif->est_vu == 0 ? 'fw-bold' : 'text-muted' }}">
                                        {{ $notif->message }}
                                        <div class="small text-muted mt-1">{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}</div>
                                    </div>
                                </a>
                            </li>
                            <div class="dropdown-divider m-0"></div>
                            @endif
                            @endforeach

                            @if(!$hasUnread)
                            <li>
                                <div class="dropdown-item text-center py-3 text-muted">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Aucune notification
                                </div>
                            </li>
                            @endif
                            @else
                            <li>
                                <div class="dropdown-item text-center py-3 text-muted">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Aucune notification
                                </div>
                            </li>
                            @endif

                        </ul>
                    </div>
                    @endisset

                    <!-- User Profile -->
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-circle fs-5 me-2"></i>
                        <span class="fw-bold">Bonjour, {{ Auth::user()->name }}</span>
                    </div>
                </div>
            </nav>

            <!-- Contenu de la page -->
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script pour la déconnexion avec SweetAlert2 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('logout-button').addEventListener('click', function() {
                Swal.fire({
                    title: 'Voulez-vous vraiment vous déconnecter ?',
                    text: "Vous serez redirigé vers la page de connexion.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, déconnexion',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });
            });

            const dropdownButton = document.getElementById('messageDropdown');
            const dropdownMenu = document.getElementById('messageDropdownMenu');


        });

        function markAsRead(element) {
            let notifId = element.getAttribute("data-id");

            fetch('/notifications/mark-as-read/' + notifId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                }).then(response => response.json())
                .then(data => {
                    pass; //lol
                }).catch(error => console.error('Erreur:', error));
        }
    </script>
    @yield('scripts')
</body>

</html>