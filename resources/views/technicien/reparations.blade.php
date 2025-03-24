@extends('layouts.technicien')

@section('content')
<h2 class="mb-4 text-xl font-bold">Réparation de l'émetteur : {{ $emetteur->type }}</h2>

<form action="{{ route('technicien.enregistrerReparation', $intervention->id) }}" method="POST">
    @csrf

    <div class="mb-4">
        <label for="date_reparation" class="block">Date de réparation :</label>
        <input type="date" name="date_reparation" value="{{ old('date_reparation') }}" class="w-full p-2 border">
    </div>

    <div class="mb-4">
        <label for="pieces_utilisees" class="block">Pièces utilisées :</label>
        <select name="pieces_utilisees[]" multiple class="w-full p-2 border">
            @foreach($pieces as $piece)
                <option value="{{ $piece->id }}">{{ $piece->nom_piece }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label for="commentaire" class="block">Commentaire :</label>
        <textarea name="commentaire" class="w-full p-2 border">{{ old('commentaire') }}</textarea>
    </div>

    <button type="submit" class="p-2 text-white bg-blue-500 rounded">Enregistrer la réparation</button>
</form>
@endsection
