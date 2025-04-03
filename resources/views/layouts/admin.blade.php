<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-5.3.1-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <title>@yield('title', 'Dashboard')</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="pt-3 logo ms-5">
                <a href="#"><img src="{{ asset('images/logo-ORTM.png') }}" alt="Logo"></a>
            </div>
            <div class="my-3 list-group list-group-flush">
                <a href="{{ route('admin.dashboard') }}" class="bg-transparent list-group-item list-group-item-action second-text active">
                    <i class="bi bi-bar-chart-fill me-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.alertes.index') }}" class="bg-transparent list-group-item list-group-item-action second-text fw-bold {{ request()->routeIs('admin.alertes.*') ? 'active' : '' }}">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Alerte
                </a>
                <a href="{{ route('admin.localisations.index') }}" class="bg-transparent list-group-item list-group-item-action second-text fw-bold">
                    <i class="bi bi-pin-map-fill me-2"></i> Localisation
                </a>
                <a href="{{ route('admin.emetteurs.index') }}" class="bg-transparent list-group-item list-group-item-action second-text fw-bold">
                    <i class="bi bi-broadcast me-2"></i> Emetteur
                </a>
                <a href="{{ route('admin.stations.index') }}" class="bg-transparent list-group-item list-group-item-action second-text fw-bold">
                    <i class="bi bi-broadcast me-2"></i> Stations
                </a>
                <a href="{{ route('admin.pieces.index') }}" class="bg-transparent list-group-item list-group-item-action second-text fw-bold">
                    <i class="bi bi-puzzle-fill me-2"></i> Pièces
                </a>
                <a href="{{ route('admin.interventions.index') }}" class="bg-transparent list-group-item list-group-item-action second-text fw-bold {{ request()->routeIs('admin.interventions.*') ? 'active' : '' }}">
                    <i class="bi bi-tools me-2"></i> Intervention
                </a>

                <!-- Logout Form with SweetAlert -->
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <button type="button" id="logout-button" class="bg-transparent list-group-item list-group-item-action text-danger fw-bold">
                        <i class="bi bi-power me-2"></i> Deconnexion
                    </button>
                </form>

            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script pour la déconnexion avec SweetAlert -->
    <script>
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
                    document.getElementById('logout-form').submit(); // Soumettre le formulaire de déconnexion
                }
            });
        });
    </script>

</body>

</html>