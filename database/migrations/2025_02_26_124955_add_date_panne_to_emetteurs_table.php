<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('emetteurs', function (Blueprint $table) {
        $table->date('date_panne')->nullable(); // Ajoute la colonne date_panne
    });
}

public function down()
{
    Schema::table('emetteurs', function (Blueprint $table) {
        $table->dropColumn('date_panne'); // Supprime la colonne date_panne si la migration est annulée
    });
}

};
