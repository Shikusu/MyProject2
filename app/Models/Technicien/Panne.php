<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Importer le modèle Emetteur
use App\Models\Admin\Emetteur;

class Panne extends Model
{
    use HasFactory;

    // Définir la relation avec le modèle Emetteur
    public function emetteur()
    {
        return $this->belongsTo(Emetteur::class);
    }
}
