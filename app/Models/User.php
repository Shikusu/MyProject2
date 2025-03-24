<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'role', 'notifications_count'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Vérifier si l'utilisateur est un administrateur
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Vérifier si l'utilisateur est un technicien
    public function isTechnicien()
    {
        return $this->role === 'technicien';
    }

    // Réinitialiser le compteur de notifications
    public function resetNotificationsCount()
    {
        // Réinitialiser le compteur de notifications
        $this->notifications_count = 0;
        $this->save();  // Sauvegarde du modèle après réinitialisation
    }
}
