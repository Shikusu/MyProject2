<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <title>@yield('title', 'Dashboard Technicien') - {{ Auth::user()->name }}</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-5.3.1-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Noty -->
    <link href="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta-deprecated/lib/noty.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta-deprecated/lib/noty.min.js"></script>

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        #wrapper {
            display: flex;
            height: 100vh;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
        }

        #sidebar-wrapper {
            width: 250px;
            flex-shrink: 0;
            height: 100%;
            overflow-y: auto;
            transition: all 0.3s ease-in-out;
            background-color: #fff;
            z-index: 1000;
        }

        #sidebar-wrapper.collapsed {
            margin-left: -250px;
        }

        #page-content-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        .page-scrollable-content {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px;
            background-color: #f8f9fa;
        }

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

        .btn-notif-icon:hover,
        .btn-notif-icon:focus,
        .btn-notif-icon:active {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            outline: none !important;
        }

        nav.navbar {
            border: none !important;
            box-shadow: none !important;
        }

        .border-bottom {
            border-bottom: none !important;
        }

        .small-text-swal .swal2-html-container {
            font-size: 0.85rem;
            /* Taille plus petite */
        }
    </style>

    <script>
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function() {
            window.history.pushState(null, null, window.location.href);
        };
    </script>
</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="pt-3 logo ms-5">
                <a href="#"><img src="{{ asset('images/logo-ORTM.png') }}" alt="Logo"></a>
            </div>
            <div class="my-3 list-group list-group-flush">
                <a href="{{ route('technicien.dashboard') }}" class="bg-transparent list-group-item active">
                    <i class="bi bi-house-door-fill me-2"></i> Tableau de bord
                </a>
                <a href="{{ route('technicien.emetteurs') }}"
                    class="bg-transparent list-group-item list-group-item-action fw-bold">
                    <i class="bi bi-radioactive me-2"></i> Émetteurs en Suivi
                </a>
                <a href="{{ route('technicien.historiques') }}"
                    class="bg-transparent list-group-item list-group-item-action fw-bold">
                    <i class="bi bi-exclamation-circle me-2"></i> Signal défaillant
                </a>
                <a href="{{ route('technicien.profil') }}"
                    class="bg-transparent list-group-item list-group-item-action fw-bold">
                    <i class="bi bi-person-circle me-2"></i> Profil
                </a>
                <button type="button" class="bg-transparent list-group-item list-group-item-action text-danger fw-bold"
                    id="logout-button">
                    <i class="bi bi-power me-2"></i> Déconnexion
                </button>
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Content -->
        <div id="page-content-wrapper">
            <!-- Navbar -->
            <nav class="px-4 py-3 bg-white d-flex justify-content-between align-items-center navbar">
                <div class="d-flex align-items-center">
                    <i class="bi bi-list fs-4 me-3 text-primary" id="menu-toggle" style="cursor: pointer;"></i>
                    <h2 class="m-0 fs-2">@yield('title', 'Dashboard Technicien')</h2>
                </div>
                <div class="d-flex align-items-center">
                    @isset($notifs)
                        <div class="dropdown ms-3 me-3">
                            <button class="btn-notif-icon" type="button" id="messageDropdown" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-bell fs-5 text-primary"></i>
                                @if ($notifs->where('est_lu', 0)->count() > 0)
                                    <span
                                        class="top-0 position-absolute start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $notifs->where('est_lu', 0)->count() }}
                                    </span>
                                @endif
                            </button>
                            <ul class="py-0 border-0 shadow dropdown-menu dropdown-menu-end"
                                aria-labelledby="messageDropdown" id="messageDropdownMenu"
                                style="min-width: 280px; max-height: 350px; overflow-y: auto;">
                                <li
                                    class="px-3 py-2 dropdown-header bg-light d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-primary">Notifications</span>
                                    @if ($notifs->where('est_lu', 0)->count() > 0)
                                        <span
                                            class="badge bg-primary rounded-pill">{{ $notifs->where('est_lu', 0)->count() }}</span>
                                    @endif
                                </li>
                                <div class="m-0 dropdown-divider"></div>
                                @php $hasUnread = false; @endphp
                                @foreach ($notifs as $notif)
                                    @if ($notif->est_lu != 1)
                                        @php $hasUnread = true; @endphp
                                        <li>
                                            <a class="dropdown-item py-2 px-3 d-flex align-items-center {{ $notif->est_vu == 0 ? 'bg-light' : '' }}"
                                                href="{{ route('technicien.historiques') }}" data-id="{{ $notif->id }}"
                                                onclick="markAsRead(this)">
                                                <div class="me-2">
                                                    <i
                                                        class="bi bi-info-circle{{ $notif->est_vu == 0 ? '-fill text-primary' : ' text-secondary' }}"></i>
                                                </div>
                                                <div class="{{ $notif->est_vu == 0 ? 'fw-bold' : 'text-muted' }}">
                                                    {{ $notif->message }}
                                                    <div class="mt-1 small text-muted">
                                                        {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <div class="m-0 dropdown-divider"></div>
                                    @endif
                                @endforeach
                                @if (!$hasUnread)
                                    <li>
                                        <div class="py-3 text-center dropdown-item text-muted">
                                            <i class="bi bi-check-circle me-1"></i> Aucune notification
                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endisset
                    <div class="d-flex align-items-center">
                        @if (Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Photo de profil"
                                class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle fs-5 me-2"></i>
                        @endif
                        <span class="fw-bold">Bonjour, {{ Auth::user()->prenom }} {{ Auth::user()->name }}</span>
                    </div>

                </div>
            </nav>

            <!-- Scrollable Page Content -->
            <div class="page-scrollable-content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
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

            // Animation toggle sidebar
            document.getElementById('menu-toggle').addEventListener('click', function() {
                document.getElementById('sidebar-wrapper').classList.toggle('collapsed');
            });
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
                    location.reload();
                }).catch(error => console.error('Erreur:', error));
        }
    </script>
@stack('scripts')

    @yield('scripts')
</body>

</html>
