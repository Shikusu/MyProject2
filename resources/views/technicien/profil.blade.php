@extends('layouts.technicien')

@section('title', 'Mon Profil')

@section('content')

    <div class="p-4 border-0 shadow card rounded-4">
        <div class="row align-items-center">
            <div class="text-center col-md-4">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($technicien->name) }}&background=0D8ABC&color=fff&size=140"
                     class="shadow rounded-circle" alt="Photo de profil">
            </div>
            <div class="col-md-8">
                <h3 class="mb-3 fw-bold">{{ $technicien->name }}</h3>
                <p><strong>Email :</strong> {{ $technicien->email }}</p>
                <p><strong>Rôle :</strong> {{ ucfirst($technicien->role ?? 'Technicien') }}</p>
                <a href="#" class="mt-3 btn btn-outline-primary">Modifier mes infos</a>
            </div>
        </div>
    </div>

@endsection
