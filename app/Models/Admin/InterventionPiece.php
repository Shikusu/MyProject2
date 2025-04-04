<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Piece;
use App\Models\Admin\Intervention;

class InterventionPiece extends Model
{
    use HasFactory;

    protected $table = 'intervention_piece'; // Define the table name if it's not pluralized

    protected $fillable = [
        'intervention_id',
        'piece_id',
    ];

    public $timestamps = true;

    // Define relationships
    public function intervention()
    {
        return $this->belongsTo(Intervention::class, 'intervention_id');
    }

    public function piece()
    {
        return $this->belongsTo(Piece::class, 'piece_id');
    }
}
