<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'prenom',
        'email',
        'password',
        'role',
        'matricule',
        'photo',
        'notifications_count',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Vérifie si l'utilisateur est un administrateur
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Vérifie si l'utilisateur est un technicien
     */
    public function isTechnicien()
    {
        return $this->role === 'technicien';
    }

    /**
     * Réinitialise le compteur de notifications à 0
     */
    public function resetNotificationsCount()
    {
        $this->notifications_count = 0;
        $this->save(); // Cette méthode est bien disponible car héritée d’Eloquent
    }

    /**
     * Accesseur pour retourner l'URL complète de la photo
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
}
