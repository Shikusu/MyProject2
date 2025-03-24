<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    use HasFactory;

    protected $table = 'pieces'; // Assurez-vous que le nom de la table est correct

    protected $fillable = [
        'nom',
        'type',
        'quantite',
    ];

    // Définir la relation entre Piece et Intervention
    public function interventions()
    {
        return $this->belongsToMany(Intervention::class, 'intervention_piece'); // Table pivot
    }
}
