<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterventionPieceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervention_piece', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intervention_id')->constrained()->onDelete('cascade'); // Référence à l'intervention
            $table->foreignId('piece_id')->constrained()->onDelete('cascade'); // Référence à la pièce
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('intervention_piece');
    }
}
