<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    use HasFactory;
    protected $table = 'type_alerte'; // <== Indique la bonne table ici


<<<<<<< HEAD
    protected $fillable = ['type'];

=======
    protected $fillable = [
        'emetteur_id',
        'type',
        'message',
        'date_alerte',
        'status',
        'resolue',
        'is_read'
    ];
>>>>>>> 0b3433a30e3fd718479fae58f69306470fb85508

    public function emetteur()
    {
        return $this->belongsTo(Emetteur::class);
    }
}
