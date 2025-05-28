<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Localisation; // Importation de la classe Localisation
use App\Models\Admin\Intervention; // Importation de la classe Intervention
use App\Models\Admin\Alerte; // Importation de la classe Alerte

class Emetteur extends Model
{
    protected $table = 'emetteurs'; // Vérifie que le nom de la table est correct

    use HasFactory;

    protected $fillable = [
        'type',
        'reference',
        'localisation_id',
        'date_installation',
        'derniere_maintenance',
        'maintenance_prevue',
        'status', // Ajouté pour l'état de l'émetteur
        'panne_declenchee', // Ajouté pour marquer la panne
        'date_panne',
        'date_entree',     // 👈 ajouté
        'date_sortie'      // 👈 ajouté
    ];

    // Relation avec la table Localisation
    // Dans le modèle Emetteur
    public function localisation()
    {
        return $this->belongsTo(Localisation::class, 'localisation_id');
    }




    // Relation avec la table Intervention
    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }
    public function derniereIntervention()
    {
        return $this->hasOne(Intervention::class)->latestOfMany();
    }
}
