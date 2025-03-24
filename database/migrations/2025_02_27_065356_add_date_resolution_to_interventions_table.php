<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('interventions', function (Blueprint $table) {
            // Si vous n'avez pas de colonne 'date_creation', utilisez une autre colonne existante
            $table->timestamp('date_resolution')->nullable(); // Retirer l'option 'after' si nécessaire
        });
    }


public function down()
{
    Schema::table('interventions', function (Blueprint $table) {
        $table->dropColumn('date_resolution');
    });
}

};
