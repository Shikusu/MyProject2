<script>
    // Empêche le retour à la page précédente après la déconnexion
    window.history.pushState(null, null, window.location.href);
    window.onpopstate = function() {
        window.history.pushState(null, null, window.location.href);
    };
</script>


@extends('layouts.app')

@section('title', 'Déconnexion')

@section('content')
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="shadow-lg card" style="width: 600px; border-radius: 15px;">
            <div class="text-center card-body">
                <h2 class="mb-4">Voulez-vous vraiment vous déconnecter ?</h2>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-50">Se déconnecter</button>
                </form>
            </div>
        </div>
    </div>
@endsection
