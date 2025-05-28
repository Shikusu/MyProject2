<!DOCTYPE html>
<html lang="en">

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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Noty CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.2.0-beta/noty.min.css"
        integrity="sha512-...==" crossorigin="anonymous" />

    <!-- Noty JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.2.0-beta/noty.min.js" integrity="sha512-...=="
        crossorigin="anonymous"></script>

    {{-- <title>@yield('title', 'Dashboard')</title> --}}
</head>
<style>
    /* Rendre le bouton de notification transparent, sans bordure ni fond */
    .btn-notif-icon {
        background: transparent !important;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        padding: 8px;
        position: relative;
        border-radius: 50%;
        cursor: pointer;
    }

    /* Supprimer tout effet au survol, focus ou clic */
    .btn-notif-icon:hover,
    .btn-notif-icon:focus,
    .btn-notif-icon:active {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        outline: none !important;
    }

    /* Badge rouge de notification */
    .notif-badge {
        position: absolute;
        top: 0;
        left: 60%;
        transform: translate(-50%, -50%);
        font-size: 0.6rem;
        padding: 2px 6px;
        border-radius: 999px;
        background-color: #dc3545;
        /* rouge */
        color: white;
    }

    /* Menu déroulant notification */
    .notif-dropdown-menu {
        min-width: 280px;
        max-height: 350px;
        overflow-y: auto;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        border: none;
        padding: 0;
    }

    /* En-tête du dropdown */
    .notif-header {
        padding: 12px 16px;
        background-color: #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Lien notification */
    .notif-item {
        padding: 10px 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
</style>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="pt-3 logo ms-5">
                <a href="#"><img src="{{ asset('images/logo-ORTM.png') }}" alt="Logo"></a>
            </div>
            <div class="my-3 list-group list-group-flush">
                <a href="{{ route('admin.dashboard') }}"
                    class="bg-transparent list-group-item list-group-item-action second-text {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill me-2"></i> Tableau de bord
                </a>
                <a href="{{ route('admin.alertes.index') }}"
                    class="bg-transparent list-group-item list-group-item-action second-text fw-bold {{ request()->routeIs('admin.alertes.*') ? 'active' : '' }}">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Alerte
                </a>
                <a href="{{ route('admin.localisations.index') }}"
                    class="bg-transparent list-group-item list-group-item-action second-text fw-bold {{ request()->routeIs('admin.localisations.*') ? 'active' : '' }}">
                    <i class="bi bi-pin-map-fill me-2"></i> Localisation
                </a>
                <a href="{{ route('admin.emetteurs.index') }}"
                    class="bg-transparent list-group-item list-group-item-action second-text fw-bold {{ request()->routeIs('admin.emetteurs.*') ? 'active' : '' }}">
                    <i class="bi bi-broadcast me-2"></i> Emetteur
                </a>
                <a href="{{ route('admin.pieces.index') }}"
                    class="bg-transparent list-group-item list-group-item-action second-text fw-bold {{ request()->routeIs('admin.pieces.*') ? 'active' : '' }}">
                    <i class="bi bi-puzzle-fill me-2"></i> Pièces
                </a>
                <a href="{{ route('admin.interventions.index') }}"
                    class="bg-transparent list-group-item list-group-item-action second-text fw-bold {{ request()->routeIs('admin.interventions.*') ? 'active' : '' }}">
                    <i class="bi bi-tools me-2"></i> Intervention
                </a>
                <a href="{{ route('admin.techniciens.index') }}"
                    class="bg-transparent list-group-item list-group-item-action second-text fw-bold {{ request()->routeIs('admin.techniciens.*') ? 'active' : '' }}">
                    <i class="bi bi-person-fill me-2"></i> Techniciens
                </a>
                <!-- Logout Form -->
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <button type="button" id="logout-button"
                        class="bg-transparent list-group-item list-group-item-action text-danger fw-bold">
                        <i class="bi bi-power me-2"></i> Deconnexion
                    </button>
                </form>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="px-4 py-4 bg-transparent navbar navbar-expand-lg navbar-light d-flex justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="m-0 fs-2">@yield('page-title', 'Dashboard')</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="mb-2 navbar-nav ms-auto mb-lg-0">
                        @isset($notifs)
                            <!-- Notification Dropdown -->
                            <li class="nav-item dropdown me-3">
                                <button class="btn-notif-icon" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-bell fs-5 text-primary"></i>
                                    @if ($notifs->where('est_lu', 0)->count() > 0)
                                        <span class="notif-badge">
                                            {{ $notifs->where('est_lu', 0)->count() }}
                                            <span class="visually-hidden">messages non lus</span>
                                        </span>
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end notif-dropdown-menu">
                                    <li class="dropdown-header notif-header">
                                        <span class="fw-bold text-primary">Notifications</span>
                                        @if ($notifs->where('est_lu', 0)->count() > 0)
                                            <span
                                                class="badge bg-primary rounded-pill">{{ $notifs->where('est_lu', 0)->count() }}</span>
                                        @endif
                                    </li>
                                    <div class="m-0 dropdown-divider"></div>
                                    @forelse($notifs as $notif)
                                        @if (!$notif->est_lu)
                                            <li>
                                                <a class="dropdown-item notif-item {{ $notif->est_vu == 0 ? 'bg-light' : '' }}"
                                                    href="{{ route('admin.interventions.index') }}"
                                                    data-id="{{ $notif->id }}" onclick="markAsRead(this)">
                                                    <div class="me-2">
                                                        <i
                                                            class="bi bi-info-circle{{ $notif->est_vu == 0 ? '-fill text-primary' : ' text-secondary' }}"></i>
                                                    </div>
                                                    <div class="{{ $notif->est_vu == 0 ? 'fw-bold' : 'text-muted' }}">
                                                        {{ $notif->message }}
                                                        <div class="mt-1 small text-muted">
                                                            {{ $notif->created_at->diffForHumans() }}</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <div class="m-0 dropdown-divider"></div>
                                        @endif
                                    @empty
                                        <li>
                                            <div class="py-3 text-center dropdown-item text-muted">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Aucune notification
                                            </div>
                                        </li>
                                    @endforelse
                                </ul>
                            </li>
                        @endisset

                        <!-- User Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-user me-2"></i> {{ Auth::check() ? Auth::user()->name : 'Error' }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a href="{{ route('admin.profile.show') }}">Profil</a></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Deconnexion</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

            </nav>

            <!-- Main Content -->
            <div class="px-4 container-fluid">
                @yield('contenu')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Sidebar toggle
        const wrapper = document.getElementById("wrapper");
        const toggleButton = document.getElementById("menu-toggle");
        toggleButton.onclick = () => wrapper.classList.toggle("toggled");

        // Logout confirmation
        document.getElementById('logout-button').addEventListener('click', function() {
            Swal.fire({
                title: 'Voulez-vous vraiment vous déconnecter ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Déconnecter',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        });

        // Mark notification as read
        function markAsRead(element) {
            const notifId = element.getAttribute("data-id");
            fetch(`/notifications/mark-as-read/${notifId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    element.closest('li').remove(); // Remove notification after marking as read
                })
                .catch(error => console.error('Erreur:', error));
        }
    </script>
    @stack('scripts')

</body>

</html>
