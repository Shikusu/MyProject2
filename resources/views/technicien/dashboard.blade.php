@extends('layouts.technicien')

@section('title', 'Tableau de Bord')

@section('content')
    <div class="row">
        <div class="card">
            <!-- Card pour le nombre d'émetteurs -->
            <div class="mb-4 col-lg-4 col-md-6">
                <div class="border-0 rounded-lg shadow-lg card">
                    <div class="text-white card-body bg-primary rounded-top">
                        <h5 class="card-title">Nombre d'Émetteurs</h5>
                        <h2 class="card-text">{{ $nombreEmetteurs }}</h2>
                    </div>
                    <div class="bg-transparent border-0 card-footer">
                        <a href="{{ route('technicien.emetteurs') }}" class="btn btn-light w-100">Voir les émetteurs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
