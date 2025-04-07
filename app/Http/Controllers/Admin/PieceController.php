<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Piece;
use App\Models\Notification;

use Illuminate\Http\Request;

class PieceController extends Controller
{
    // ✅ Affichage de la liste des pièces avec pagination + recherche
    public function index(Request $request)
    {
        $searchQuery = $request->input('search'); // Récupère la recherche saisie s'il y en a

        // Début de la requête sur la table Piece
        $piecesQuery = Piece::query();
        $notifs = Notification::where('user_id', 2)->get();
        // Si une recherche est faite, on filtre les résultats
        if ($searchQuery) {
            $piecesQuery->where('nom', 'like', '%' . $searchQuery . '%')
                ->orWhere('type', 'like', '%' . $searchQuery . '%');
        }

        // Pagination des résultats (5 par page)
        $pieces = $piecesQuery->paginate(5);

        // Retour de la vue avec les pièces et la recherche courante
        return view('admin.pieces', compact('pieces', 'searchQuery', 'notifs'));
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

        // Retour avec SweetAlert après succès
        return redirect()->route('admin.pieces.index')
            ->with('success', isset($request->id) ? 'Pièce modifiée avec succès.' : 'Pièce ajoutée avec succès.');
    }

    // ✅ Formulaire de modification d'une pièce
    public function edit($id)
    {
        $pieces = Piece::paginate(5);
        $piece = Piece::findOrFail($id);
        return view('admin.pieces', compact('piece', 'pieces'));
    }

    // ✅ Mise à jour d'une pièce (modification)
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:15',
            'type' => 'required|string|max:15',
            'quantite' => 'required|integer|min:1',
        ]);

        // Trouver la pièce à modifier
        $piece = Piece::findOrFail($id);

        // Mise à jour des informations de la pièce
        $piece->nom = $validated['nom'];
        $piece->type = $validated['type'];
        $piece->quantite = $validated['quantite'];

        // Sauvegarde des modifications
        $piece->save();

        // Retour avec SweetAlert après succès
        return redirect()->route('admin.pieces.index')
            ->with('success', 'Pièce modifiée avec succès.');
    }

    // ✅ Suppression d'une pièce
    public function destroy($id)
    {
        $piece = Piece::findOrFail($id);
        $piece->delete();

        return redirect()->route('admin.pieces.index')->with('success', 'Pièce supprimée avec succès.');
    }
}
