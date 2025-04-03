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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <title>Dashboard</title>

    <style>
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: scale(1.05);
            /* Léger agrandissement */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            /* Ajout d'une ombre légère */
        }

        a {
            text-decoration: none;
            /* Supprime le soulignement du texte */
        }

        .card-header,
        .card-body {
            user-select: none;
            /* Empêche la sélection de texte */
        }
    </style>

</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="pt-3 logo ms-5">
                <a href="#"><img src="{{ asset('images/logo-ORTM.png') }}" alt="Logo"></a>
            </div>
            <div class="my-3 list-group list-group-flush">
                <a href="#" class="bg-transparent list-group-item list-group-item-action second-text active">
                    <i class="bi bi-bar-chart-fill me-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.alertes.index') }}" class="bg-transparent list-group-item list-group-item-action second-text fw-bold">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Alerte
                </a>
                <a href="{{ route('admin.localisations.index') }}" class="bg-transparent list-group-item list-group-item-action second-text fw-bold">
                    <i class="bi bi-map-fill"></i> Localisation
                </a>
                <a href="{{ route('admin.emetteurs.index') }}" class="bg-transparent list-group-item list-group-item-action second-text fw-bold">
                    <i class="bi bi-broadcast me-2"></i> Emetteur
                </a>
                <a href="{{ route('admin.pieces.index') }}" class="bg-transparent list-group-item list-group-item-action second-text fw-bold">
                    <i class="bi bi-puzzle-fill me-2"></i> Pieces
                </a>
                <a href="{{ route('admin.interventions.index') }}" class="bg-transparent list-group-item list-group-item-action second-text fw-bold">
                    <i class="bi bi-tools me-2"></i> Intervention
                </a>

                <!-- Logout Form -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-transparent list-group-item list-group-item-action text-danger fw-bold">
                        <i class="bi bi-power me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="px-4 py-4 bg-transparent navbar navbar-expand-lg navbar-light">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="m-0 fs-2">Dashboard</h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
                                        href="{{ route('admin.interventions.index') }}"
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
                    </div>
                    <ul class="mb-2 navbar-nav ms-auto mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i> {{ Auth::check() ? Auth::user()->name : 'Error' }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="px-4 container-fluid">
                <div class="my-2 row g-3">
                    <!-- Card for total number of emitters, made clickable -->
                    <div class="col-md-2">
                        <a href="{{ route('admin.emetteurs.index') }}">
                            <div class="mb-3 text-white card" style="background: linear-gradient(to right, #e74c3c, #c0392b); border: none;">
                                <div class="text-center card-header fw-bold">Nombre Total d'Émetteurs</div>
                                <div class="text-center card-body">
                                    <h3 class="fs-3">{{ $nombreEmetteurs }}</h3>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="my-5 row">
                    <h3 class="mb-3 fs-4">Recent Orders</h3>
                    <div class="col">
                        <table class="table bg-white rounded shadow-sm table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" width="50">#</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Add your rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function() {
            el.classList.toggle("toggled");
        };

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
</body>

</html>