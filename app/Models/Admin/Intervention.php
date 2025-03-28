<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;

    protected $fillable = [
        'emetteur_id',
        'date_panne',
        'message',
        'type_alerte',
        'date_reparation',         // Date de la réparation
        'description_reparation',  // Description de la réparation
        'status',
        'date_reparation_fait'                // Statut de l'intervention (ex: 'réparée')
    ];

    // Définir la relation entre Intervention et Emetteur
    public function emetteur()
    {
        return $this->belongsTo(Emetteur::class);
    }

    // Relation avec les pièces utilisées pour l'intervention
    public function pieces()
    {
        return $this->belongsToMany(Piece::class, 'intervention_piece'); // Table pivot
    }

    // Relation avec les alertes (si nécessaire)
    public function alertes()
    {
        return $this->hasMany(Alerte::class);
    }
}
