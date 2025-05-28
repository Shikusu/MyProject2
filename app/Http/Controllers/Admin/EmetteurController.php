<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Emetteur;
use App\Models\Admin\Localisation;
use App\Models\Notification;
use Illuminate\Http\Request;

class EmetteurController extends Controller
{
    public function index()
    {
        $localisations = Localisation::all();
        $notifs = Notification::where('user_id', 2)->get();
        $emetteurs = Emetteur::with('localisation')->paginate(10);

        return view('admin.emetteurs', compact('localisations', 'emetteurs', 'notifs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:radio,television',
            'reference_display' => 'required|string|max:10',
            'localisation_id' => 'required|exists:localisations,id',
            'date_installation' => 'required|date|before_or_equal:today',
            'derniere_maintenance' => 'nullable|date|after_or_equal:date_installation|before_or_equal:today',
            'maintenance_prevue' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && $request->filled('derniere_maintenance') && $value <= $request->derniere_maintenance) {
                        $fail("La date de maintenance prévue doit être postérieure à la dernière maintenance.");
                    }
                },
            ],
        ]);

        $prefix = $request->type === 'radio' ? 'ER - ' : 'ET - ';
        $reference = $prefix . trim($request->reference_display);

        Emetteur::create([
            'type' => $request->type,
            'reference' => $reference,
            'localisation_id' => $request->localisation_id,
            'date_installation' => $request->date_installation,
            'derniere_maintenance' => $request->derniere_maintenance,
            'maintenance_prevue' => $request->maintenance_prevue,
        ]);

        return redirect()->route('admin.emetteurs.index')->with('success', 'Émetteur ajouté avec succès.');
    }

    public function edit($id)
    {
        $emetteur = Emetteur::findOrFail($id);
        $localisations = Localisation::all();
        $emetteurs = Emetteur::with('localisation')->paginate(10);
        $notifs = Notification::where('user_id', 2)->get();

        return view('admin.emetteurs', compact('emetteur', 'localisations', 'emetteurs', 'notifs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:radio,television',
            'reference_display' => 'required|string|max:10',
            'localisation_id' => 'required|exists:localisations,id',
            'date_installation' => 'required|date|before_or_equal:today',
            'derniere_maintenance' => 'nullable|date|after_or_equal:date_installation|before_or_equal:today',
            'maintenance_prevue' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value && $request->filled('derniere_maintenance') && $value <= $request->derniere_maintenance) {
                        $fail("La date de maintenance prévue doit être postérieure à la dernière maintenance.");
                    }
                },
            ],
        ]);

        $prefix = $request->type === 'radio' ? 'ER - ' : 'ET - ';
        $reference = $prefix . trim($request->reference_display);

        $emetteur = Emetteur::findOrFail($id);
        $emetteur->update([
            'type' => $request->type,
            'reference' => $reference,
            'localisation_id' => $request->localisation_id,
            'date_installation' => $request->date_installation,
            'derniere_maintenance' => $request->derniere_maintenance,
            'maintenance_prevue' => $request->maintenance_prevue,
        ]);

        return redirect()->route('admin.emetteurs.index')->with('success', 'Émetteur modifié avec succès.');
    }

    public function destroy($id)
    {
        $emetteur = Emetteur::findOrFail($id);
        $emetteur->delete();

        return redirect()->route('admin.emetteurs.index')->with('success', 'Émetteur supprimé avec succès.');
    }
}
