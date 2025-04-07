@extends('layouts.admin')

@section('title', 'Tableau de Bord')
@section('page-title', 'Tableau de Bord')

@section('contenu')
<div class="my-2 row g-3">
    <div class="col-md-2">
        <a href="{{ route('admin.emetteurs.index') }}" class="text-decoration-none">
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
@endsection