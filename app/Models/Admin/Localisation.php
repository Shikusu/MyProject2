<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Localisation extends Model
{
    protected $table = 'localisations'; // Assure-toi que ce nom correspond à ta table
    protected $fillable = ['nom']; // Les colonnes de ta table que tu veux rendre mass assignable
}
