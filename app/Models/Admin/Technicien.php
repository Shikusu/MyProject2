<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technicien extends Model
{
    use HasFactory;
    protected $table = 'users';
    // Définir les attributs qui peuvent être assignés massivement
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Assurez-vous que le rôle est bien attribué
    ];

    // Si vous n'utilisez pas la gestion par défaut des timestamps
    // Si vous utilisez des timestamps personnalisés, commentez ou supprimez cette ligne
    public $timestamps = true;

    // Exemple de relation : Si un technicien a plusieurs interventions
    // public function interventions()
    // {
    //     return $this->hasMany(Intervention::class);
    // }
}
