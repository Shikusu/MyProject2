<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    use HasFactory;
    protected $table = 'type_alerte'; 



    protected $fillable = ['type'];



    public function emetteur()
    {
        return $this->belongsTo(Emetteur::class);
    }
}
