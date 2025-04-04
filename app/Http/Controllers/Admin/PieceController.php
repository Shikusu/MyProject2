<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Piece;
use Illuminate\Http\Request;

class PieceController extends Controller
{
    // ✅ Affichage de la liste des pièces avec pagination + recherche
    public function index(Request $request)
    {
        $searchQuery = $request->input('search'); // Récupère la recherche saisie s'il y en a

        // Début de la requête sur la table Piece
        $piecesQuery = Piece::query();

        // Si une recherche est faite, on filtre les résultats
        if ($searchQuery) {
            $piecesQuery->where('nom', 'like', '%' . $searchQuery . '%')
                ->orWhere('type', 'like', '%' . $searchQuery . '%');
        }

        // Pagination des résultats (5 par page)
        $pieces = $piecesQuery->paginate(5);

        // Retour de la vue avec les pièces et la recherche courante
        return view('admin.pieces', compact('pieces', 'searchQuery'));
    }

    // ✅ Ajouter ou modifier une pièce (fonction unique)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:15',
            'type' => 'required|string|max:15',
            'quantite' => 'required|integer|min:1',
        ]);

        // Si un ID est présent, on modifie la pièce existante
        $piece = $request->id ? Piece::findOrFail($request->id) : new Piece;

        $piece->nom = $validated['nom'];
        $piece->type = $validated['type'];
        $piece->quantite = $validated['quantite'];

        $piece->save();

        return redirect()->route('admin.pieces.index')->with('success', 'Pièce enregistrée avec succès.');
    }

    // ✅ Formulaire de modification d'une pièce
    public function edit($id)
    {
        $pieces = Piece::paginate(5);
        $piece = Piece::findOrFail($id);
        return view('admin.pieces', compact('piece', 'pieces'));
    }

    // ✅ Suppression d'une pièce
    public function destroy($id)
    {
        $piece = Piece::findOrFail($id);
        $piece->delete();

        return redirect()->route('admin.pieces.index')->with('success', 'Pièce supprimée avec succès.');
    }
}
