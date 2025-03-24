<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    use HasFactory;

    protected $fillable = [
        'emetteur_id',
        'technicien_id',
        'type',
        'message',
        'date_alerte',
        'status',
        'resolue',
        'is_read'
    ];

    public function emetteur()
    {
        return $this->belongsTo(Emetteur::class);
    }

    public function technicien()
    {
        return $this->belongsTo('App\Models\User', 'technicien_id');
    }
}
