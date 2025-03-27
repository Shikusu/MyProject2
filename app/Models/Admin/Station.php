<?php

namespace App\Models\Admin;  // Le namespace correspond à 'App\Models\Admin'

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $table = 'stations';  // Si le nom de la table est 'stations'
    protected $fillable = [
        'nom', 'statut', 'description', // Remplace ces colonnes selon ta structure
    ];
}
